<?php

namespace App\Http\Controllers;

use App\Question;
use App\Test;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Test $test)
    {
        $questions = Question::where('test_id',$test->id)
        ->orderBy('order_by')
            ->get();
        $data = [
            'test'=>$test,
            'questions'=>$questions,
        ];
        return view('questions.index',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Test $test)
    {
        if($test->user_id != auth()->user()->id){
            $words = "這不是你的問卷！";
            return view('error',compact('words'));
        }

        $data = [
            'test'=>$test,
        ];
        return view('questions.create',$data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $att['order_by'] = $request->input('order_by');
        $att['title'] = $request->input('title');
        $att['description'] = $request->input('description');
        $att['type'] = $request->input('type');
        $att['test_id'] = $request->input('test_id');
        $att['content'] = serialize($request->input('option'));

        Question::create($att);
        return redirect()->route('questions.index',$request->input('test_id'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
