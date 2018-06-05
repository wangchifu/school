<?php

namespace App\Http\Controllers;

use App\Classroom;
use App\ClassroomOrder;
use App\Http\Requests\ClassroomRequest;
use Illuminate\Http\Request;

class ClassroomController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $classrooms = Classroom::all();
        $data = [
            'classrooms'=>$classrooms,
        ];
        return view('classrooms.index',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('classrooms.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ClassroomRequest $request)
    {
        $att['name'] = $request->input('name');
        $att['disable'] = $request->input('disable');
        $close_section = $request->input('close_section');

        $att['close_sections']="";
        foreach($close_section as $k=>$v){
            foreach($v as $k1 => $v1){
                $att['close_sections'] .= $k."-".$k1.",";
            }

        }
        $att['close_sections'] = substr($att['close_sections'],0,-1);
        Classroom::create($att);
        return redirect()->route('classrooms.index');

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
    public function destroy(Classroom $classroom)
    {
        ClassroomOrder::where('classroom_id',$classroom->id)->delete();
        $classroom->delete();
        return redirect()->route('classrooms.index');
    }
}
