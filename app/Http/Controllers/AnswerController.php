<?php

namespace App\Http\Controllers;

use App\Answer;
use App\Http\Requests\AnswerRequest;
use App\Question;
use App\Test;
use Illuminate\Http\Request;

class AnswerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AnswerRequest $request)
    {
        $att= [];
        $create = [];
        foreach($request->input('answer') as $k=>$v){
            $question = Question::where('id','=',$k)->first();
            if($question->type =="checkbox"){
                foreach($v as $k1=>$v1){
                    $att['answer'] .= $v1.",";
                }
                $att['answer'] = substr($att['answer'],0,-1);
            }else{
                $att['answer'] = $v;
            }

            $att['question_id'] = $k;
            $att['user_id'] = auth()->user()->id;
            $att['test_id'] = $request->input('test_id');
            array_push($create,$att);

            $att['answer'] = "";
        }
        Answer::insert($create);

        return redirect()->route('tests.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Test $test)
    {
        if($test->user_id != auth()->user()->id){
            $words = "你不是問卷的主人！";
            return view('layouts.error',compact('words'));
        }

        $question = [];
        $answer = [];
        $user = [];
        foreach($test->questions as $q){
            $question[$q->order_by]['id'] = $q->id;
            $question[$q->order_by]['title'] = $q->title;
            foreach($q->answers as $a){
                $answer[$a->user->order_by][$q->id] = $a->answer;
                $user[$a->user->order_by] = $a->user->job_title."-".$a->user->name;
            }
        }
        ksort($question);
        ksort($user);



        $data = [
            'test'=>$test,
            'question'=>$question,
            'answer'=>$answer,
            'user'=>$user,
        ];
        return view('tests.show',$data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(AnswerRequest $request)
    {
        $att= [];

        foreach($request->input('answer') as $k=>$v){
            $question = Question::where('id','=',$k)->first();
            if($question->type =="checkbox"){
                foreach($v as $k1=>$v1){
                    $att['answer'] .= $v1.",";
                }
                $att['answer'] = substr($att['answer'],0,-1);
            }else{
                $att['answer'] = $v;
            }

            $att['question_id'] = $k;
            $att['user_id'] = auth()->user()->id;
            $att['test_id'] = $request->input('test_id');

            $answer = Answer::where('question_id',$k)
                ->where('user_id',auth()->user()->id)
                ->first();
            $answer->update($att);
            $att['answer'] = "";

        }

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
        Answer::where('user_id',auth()->user()->id)
            ->where('test_id',$test->id)
            ->delete();
        return redirect()->route('tests.index');
    }
}
