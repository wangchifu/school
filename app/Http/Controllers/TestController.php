<?php

namespace App\Http\Controllers;

use App\Group;
use App\Http\Requests\TestRequest;
use App\Test;
use Illuminate\Http\Request;

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
        $test->delete();

        return redirect()->route('tests.index');
    }
}
