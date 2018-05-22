<?php

namespace App\Http\Controllers;

use App\Fun;
use App\YearClass;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        //type=2是學生系統
        $check_admin = Fun::where('user_id',auth()->user()->id)
            ->where('type','2')
            ->first();
        $student_admin = (empty($check_admin))?"0":"1";

        $semester = (!empty($request->input('semester')))?$request->input('semester'):get_semester();


        $semesters = [];
        $year_class = [];
        $all_student = 0;
        $stud_num = "";


        //統計班級數
        $year_class = [
            '一年級' => "",
            '二年級' => "",
            '三年級' => "",
            '四年級' => "",
            '五年級' => "",
            '六年級' => "",
            '特教班' => "",
            '總共' => "",
        ];


        if($semester) {
            $YearClasses = YearClass::all();
            if($YearClasses->count() == 0){
                $semester = "";
            }else{

                foreach ($YearClasses as $YearClass) {
                    //學期選單
                    $semesters[$YearClass->semester] = $YearClass->semester;
                    //列出指定學期的班級資料
                    if ($YearClass->semester == $semester) {
                        if (substr($YearClass->year_class, 0, 1) == 1) $year_class['一年級']++;
                        if (substr($YearClass->year_class, 0, 1) == 2) $year_class['二年級']++;
                        if (substr($YearClass->year_class, 0, 1) == 3) $year_class['三年級']++;
                        if (substr($YearClass->year_class, 0, 1) == 4) $year_class['四年級']++;
                        if (substr($YearClass->year_class, 0, 1) == 5) $year_class['五年級']++;
                        if (substr($YearClass->year_class, 0, 1) == 6) $year_class['六年級']++;
                        if (substr($YearClass->year_class, 0, 1) == 9) $year_class['特教班']++;
                        $year_class['總共']++;

                        $num = 0;
                        $boy = 0;
                        $girl = 0;

                        //列出指定班級的資料
                        if($YearClass->semester_students->count() == 0){

                        }else{
                            foreach ($YearClass->semester_students as $semester_student) {
                                if ($semester_student->at_school == "1") {
                                    $all_student++;
                                    $num++;
                                    if ($semester_student->student->sex == "1") $boy++;
                                    if ($semester_student->student->sex == "2") $girl++;
                                } else {
                                    $out_students[$semester_student->student->sn] = $semester_student->year_class->name . " " . $semester_student->student->name;
                                }
                            }
                        }

/**
                        $stud_num[$YearClass->id] = [
                            'num'=>$num,
                            'boy'=>$boy,
                            'girl'=>$girl,
                        ];
**/

                    }
                }
            }

        }

        if(empty($semesters[$semester])) $semester = "";

        $data = [
            'student_admin'=>$student_admin,
            'semesters'=>$semesters,
            'semester'=>$semester,
            'year_class'=>$year_class,
            'all_student'=>$all_student,
        ];
        return view('students.index',$data);
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
