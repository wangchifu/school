<?php

namespace App\Http\Controllers;

use App\SubstituteTeacher;
use Illuminate\Http\Request;

class TeachSectionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('teach_sections.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function substitute_teacher()
    {
        $substitute_teachers = SubstituteTeacher::orderBy('active')
            ->orderBy('teacher_name')
            ->get();
        $data = [
            'substitute_teachers'=>$substitute_teachers,
        ];
        return view('teach_sections.substitute_teacher',$data);
    }

    public function substitute_teacher_store(Request $request)
    {
        $att['teacher_name'] = $request->input('teacher_name');
        $att['ps'] = $request->input('ps');
        $att['active'] = '1';
        SubstituteTeacher::create($att);
        return redirect()->route('substitute_teacher.index');
    }

    public function substitute_teacher_update(Request $request,SubstituteTeacher $substitute_teacher)
    {
        $att['teacher_name'] = $request->input('teacher_name');
        $att['ps'] = $request->input('ps');
        $att['active'] = '1';
        $substitute_teacher->update($att);
        return redirect()->route('substitute_teacher.index');
    }

    public function substitute_teacher_change(SubstituteTeacher $substitute_teacher)
    {
        $att['active'] = ($substitute_teacher->active=='1')?'2':'1';
        $substitute_teacher->update($att);
        return redirect()->route('substitute_teacher.index');
    }

    public function substitute_teacher_destroy(SubstituteTeacher $substitute_teacher)
    {
        $substitute_teacher->delete();
        return redirect()->route('substitute_teacher.index');
    }

    public function month_setup()
    {
        return view('teach_sections.month_setup');
    }


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
    public function store(Request $request)
    {
        //
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
