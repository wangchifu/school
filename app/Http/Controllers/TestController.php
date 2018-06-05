<?php

namespace App\Http\Controllers;

use App\Answer;
use App\Group;
use App\Http\Requests\TestRequest;
use App\Question;
use App\Test;
use Carbon\Carbon;
use Excel;

class TestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tests = Test::orderBy('id','DESC')->get();
        $groups = Group::where('disable',null)
            ->pluck('name', 'id')->toArray();
        $groups['0'] = '全校教職人員';

        $data = [
            'tests'=>$tests,
            'groups'=>$groups,
        ];
        return view('tests.index',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $groups = Group::where('disable',null)
            ->pluck('name', 'id')->toArray();
        $groups['0'] = '全校教職人員';
        return view('tests.create',compact('groups'));
    }

    public function copy(Test $test)
    {
        if($test->user_id != auth()->user()->id){
            $words = "這不是你的問卷！";
            return view('error',compact('words'));
        }

        $att['disable'] = 1;
        $att['name'] = $test->name;
        $att['do'] = $test->do;
        $att['user_id'] = $test->user_id;
        $date = Carbon::now()->addDays(7);

        $att['unpublished_at'] = $date->toDateString();
        $new_test = Test::create($att);
        $create = [];
        foreach($test->questions as $question){
            $att2['order_by'] = $question->order_by;
            $att2['title'] = $question->title;
            $att2['description'] = $question->description;
            $att2['type'] = $question->type;
            $att2['test_id'] = $new_test->id;
            $att2['content'] = $question->content;
            $one=[
                'order_by'=>$att2['order_by'],
                'title'=>$att2['title'],
                'description'=>$att2['description'],
                'type'=>$att2['type'],
                'test_id'=>$att2['test_id'],
                'content'=>$att2['content'],
            ];
            array_push($create,$one);
        }
        Question::insert($create);
        return redirect()->route('tests.index');


    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TestRequest $request)
    {
        Test::create($request->all());

        return redirect()->route('tests.index');
    }

    public function input(Test $test)
    {
        $questions = [];
        foreach($test->questions as $q){
            $questions[$q->order_by]['id'] = $q->id;
            $questions[$q->order_by]['title'] = $q->title;
            $questions[$q->order_by]['description'] = $q->description;
            $questions[$q->order_by]['type'] = $q->type;
            $questions[$q->order_by]['content'] = $q->content;
        }
        ksort($questions);
        $data = [
            'test'=>$test,
            'questions'=>$questions,
        ];
        return view('tests.input',$data);
    }

    public function re_input(Test $test)
    {
        foreach($test->questions as $q){
            $questions[$q->order_by]['id'] = $q->id;
            $questions[$q->order_by]['title'] = $q->title;
            $questions[$q->order_by]['description'] = $q->description;
            $questions[$q->order_by]['type'] = $q->type;
            $questions[$q->order_by]['content'] = $q->content;
            $a = Answer::where('user_id',auth()->user()->id)
                ->where('question_id',$q->id)
                ->first();
            $questions[$q->order_by]['answer'] = $a->answer;
            $questions[$q->order_by]['answer_id'] = $a->id;
        }
        ksort($questions);
        $data = [
            'test'=>$test,
            'questions'=>$questions,
        ];
        return view('tests.re_input',$data);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Test $test)
    {
        $groups = Group::where('disable',null)
            ->pluck('name', 'id')->toArray();
        $groups['0'] = '全校教職人員';
        $data = [
            'test'=>$test,
            'groups'=>$groups,
        ];
        return view('tests.edit',$data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(TestRequest $request, Test $test)
    {

        $att['disable'] = $request->input('disable');
        $att['name'] = $request->input('name');
        $att['do'] = $request->input('do');
        $att['unpublished_at'] = $request->input('unpublished_at');

        $test->update($att);
        return redirect()->route('tests.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Test $test)
    {
        if($test->user_id != auth()->user()->id){
            $words = "你不是問卷的主人！";
            return view('layouts.error',compact('words'));
        }
        Answer::where('test_id',$test->id)->delete();
        Question::where('test_id',$test->id)->delete();
        $test->delete();

        return redirect()->route('tests.index');
    }

    public function download(Test $test,$type)
    {

        if($test->user_id == auth()->user()->id){

            $questions = Question::where('test_id','=',$test->id)
                ->orderBy('order_by')
                ->get();

            $row1 = array('作答者');
            foreach($questions as $question){
                array_push($row1,$question->title);
                foreach($question->answers as $answer){
                    if(!isset($user_data[$answer->user->order_by])){
                        $user_data[$answer->user->order_by][0] = $answer->user->name;
                        array_push($user_data[$answer->user->order_by],$answer->answer);
                    }else {
                        array_push($user_data[$answer->user->order_by],$answer->answer);
                    }
                }
            }

            ksort($user_data);

            $cellData = array($row1);
            foreach($user_data as $k=>$v){
                array_push($cellData,$v);
            }

            Excel::create($test->name,function($excel) use ($cellData){
                $excel->sheet('score', function($sheet) use ($cellData){
                    $sheet->rows($cellData);
                });
            })->export($type);
        }else{
            return redirect()->route('tests.index');
        }
    }
}
