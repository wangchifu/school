<?php

namespace App\Http\Controllers;

use App\Fun;
use App\SemesterStudent;
use App\Student;
use App\UserGroup;
use App\YearClass;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

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
        $all_student = 0;
        $students_data = [];
        $out_students = [];

        //統計班級數
        $year_class = [
            '一年級' => "0",
            '二年級' => "0",
            '三年級' => "0",
            '四年級' => "0",
            '五年級' => "0",
            '六年級' => "0",
            '特教班' => "0",
            '總共' => "0",
        ];
        //統計年級學生數
        $year_stud = [
            '一年級' => "0",
            '二年級' => "0",
            '三年級' => "0",
            '四年級' => "0",
            '五年級' => "0",
            '六年級' => "0",
            '特教班' => "0",
            '總共' => "0",
        ];


        if($semester) {
            $YearClasses = YearClass::where('semester',$semester)->get();
            if($YearClasses->count() == 0){
                $semester = "";
            }else{

                foreach ($YearClasses as $YearClass) {
                    //學期選單
                    $semesters[$YearClass->semester] = $YearClass->semester;
                    //列出指定學期的班級資料
                    if ($YearClass->semester == $semester) {
                        if (substr($YearClass->year_class, 0, 1) == 1){
                            $year_class['一年級']++;
                            $year_stud['一年級'] += $YearClass->semester_students->count();
                        }
                        if (substr($YearClass->year_class, 0, 1) == 2){
                            $year_class['二年級']++;
                            $year_stud['二年級'] += $YearClass->semester_students->count();
                        }
                        if (substr($YearClass->year_class, 0, 1) == 3){
                            $year_class['三年級']++;
                            $year_stud['三年級'] += $YearClass->semester_students->count();
                        }
                        if (substr($YearClass->year_class, 0, 1) == 4){
                            $year_class['四年級']++;
                            $year_stud['四年級'] += $YearClass->semester_students->count();
                        }
                        if (substr($YearClass->year_class, 0, 1) == 5){
                            $year_class['五年級']++;
                            $year_stud['五年級'] += $YearClass->semester_students->count();
                        }
                        if (substr($YearClass->year_class, 0, 1) == 6){
                            $year_class['六年級']++;
                            $year_stud['六年級'] += $YearClass->semester_students->count();
                        }
                        if (substr($YearClass->year_class, 0, 1) == 9){
                            $year_class['特教班']++;
                            $year_stud['特教班'] += $YearClass->semester_students->count();
                        }
                        $year_class['總共']++;
                        $year_stud['總共'] += $YearClass->semester_students->count();
                        $num = 0;
                        $boy = 0;
                        $girl = 0;

                        //列出指定班級的資料
                        if($YearClass->semester_students->count() != 0){
                            foreach ($YearClass->semester_students as $semester_student) {
                                if ($semester_student->at_school == "1") {
                                    $all_student++;
                                    $num++;
                                    if ($semester_student->student->sex == "1") $boy++;
                                    if ($semester_student->student->sex == "2") $girl++;
                                } else {
                                    $out_students[$semester_student->student->sn]['班級'] = $semester_student->year_class->name;
                                    $out_students[$semester_student->student->sn]['姓名'] = $semester_student->student->name;
                                    $out_students[$semester_student->student->sn]['id'] = $semester_student->id;
                                }
                            }
                        }

                        $students_data[$YearClass->id] = [
                            'num'=>$num,
                            'boy'=>$boy,
                            'girl'=>$girl,
                        ];

                    }
                }
            }

        }

        if(empty($semesters[$semester])) $semester = "";


        //級任選單
        $teas = UserGroup::where('group_id','2')
            ->get();
        foreach($teas as $tea){
            $tea_order[$tea->user->order_by]['id'] = $tea->user_id;
            $tea_order[$tea->user->order_by]['name'] = $tea->user->job_title."-".$tea->user->name;
        }
        ksort($tea_order);
        foreach($tea_order as $k=>$v){
            $tea_menu[$v['id']] = $v['name'];
        }

        $data = [
            'student_admin'=>$student_admin,
            'semesters'=>$semesters,
            'semester'=>$semester,
            'year_class'=>$year_class,
            'year_stud'=>$year_stud,
            'all_student'=>$all_student,
            'students_data'=>$students_data,
            'out_students'=>$out_students,
            'YearClasses'=>$YearClasses,
            'tea_menu'=>$tea_menu,
        ];
        return view('students.index',$data);
    }


    public function import(Request $request)
    {
        check_admin($type=2);

        if($request->hasFile('csv')) {
            $filePath = $request->file('csv')->getRealPath();
            $data = Excel::load($filePath, function ($reader) {
            })->get();

            $create_ss = [];
            foreach ($data as $key => $value) {
                $stud_class = $value['年級'].sprintf("%02s",$value['班級']);
                $year_class = YearClass::where('semester','=',$value['學期'])
                    ->where('year_class','=',$stud_class)
                    ->first();

                //無此班級跳過
                if($year_class) {
                    //更新學生
                    $has_student = Student::where('sn', '=', $value['學號'])->first();
                    if ($has_student) {
                        //$has_student->update($att);
                        //$id = $has_student->id;
                    } else {
                        //新增學生
                        $att['sn'] = $value['學號'];
                        $att['name'] = $value['姓名'];
                        $att['sex'] = $value['性別'];
                        $student = Student::create($att);
                        $id = $student->id;
                    }


                    $att2['semester'] = $value['學期'];
                    $att2['student_id'] = $id;
                    $att2['year_class_id'] = $year_class->id;
                    $att2['num'] = sprintf("%02s", $value['座號']);
                    $att2['at_school'] = 1;

                    $new_one = [
                        'semester'=>$att2['semester'],
                        'student_id'=>$att2['student_id'],
                        'year_class_id'=>$att2['year_class_id'],
                        'num'=>$att2['num'],
                        'at_school'=>1,
                        'created_at' => date('Y-m-d H:i:s'),
                        'updated_at' => date('Y-m-d H:i:s'),
                    ];
                    array_push($create_ss, $new_one);
                }

            }
            SemesterStudent::insert($create_ss);

        }else{
            $words = "你沒有選到CSV檔案！";
            return view('layouts.error',compact('words'));
        }

        return redirect()->route('students.index');

    }

    public function clear_students($semester)
    {
        check_admin($type=2);
        SemesterStudent::where('semester',$semester)->delete();
        return redirect()->route('students.index');
    }

    public function clear_all($semester)
    {
        check_admin($type=2);

        SemesterStudent::where('semester',$semester)->delete();

        YearClass::where('semester',$semester)->delete();

        return redirect()->route('students.index');
    }

    public function add_stud(Request $request)
    {
        check_admin($type=2);

        $att1['sn'] = $request->input('sn');
        $att1['name'] = $request->input('name');
        $att1['sex'] = $request->input('sex');
        $student = Student::where('sn','=',$att1['sn'])->first();
        if($student){
            $words = "該學號已經有人使用了！";
            return view('layouts.error',compact('words'));
        }else{
            $student =  Student::create($att1);
        }
        $att2['student_id'] = $student->id;
        $att2['semester'] = $request->input('semester');
        $att2['year_class_id'] = $request->input('year_class_id');
        $att2['num'] = sprintf("%02s",$request->input('num'));
        $att2['at_school'] = "1";

        SemesterStudent::create($att2);

        return redirect()->route('students.show',$att2['year_class_id']);
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
    public function show(YearClass $year_class)
    {
        //type=2是學生系統
        $check_admin = Fun::where('user_id',auth()->user()->id)
            ->where('type','2')
            ->first();
        $student_admin = (empty($check_admin))?"0":"1";

        $student_data = [];
        foreach ($year_class->semester_students as $semester_student) {
            if($semester_student->at_school == "1") {
                $student_data[$semester_student->num]['id'] = $semester_student->id;
                $student_data[$semester_student->num]['stud_id'] = $semester_student->student->id;
                $student_data[$semester_student->num]['班級'] = $year_class->year_class;
                $student_data[$semester_student->num]['姓名'] = $semester_student->student->name;
                $student_data[$semester_student->num]['學號'] = $semester_student->student->sn;
                $student_data[$semester_student->num]['性別'] = $semester_student->student->sex;
            }
        }
        if($student_data){
            ksort($student_data);
        }

        $classes = get_class_menu($year_class->semester);

        $data = [
            "year_class"=>$year_class,
            "student_data"=>$student_data,
            'classes'=>$classes,
            'student_admin'=>$student_admin,
        ];
        return view('students.show',$data);
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
    public function update(Request $request)
    {
        check_admin($type=2);

        $semester = $request->input('semester');
        $year_class = $request->input('year_class');
        $id = $request->input('id');

        $new_year_class = YearClass::where('semester',$semester)
            ->where('year_class',$year_class)
            ->first();
        $att1['year_class_id'] = $new_year_class->id;
        $att1['num'] = $request->input('num');
        $semester_student = SemesterStudent::where('id','=',$id)
            ->first();
        $semester_student->update($att1);


        $att2['name'] = $request->input('name');
        $att2['sex'] = $request->input('sex');
        Student::where('id','=',$semester_student->student_id)->update($att2);


        return redirect()->route('students.show',$att1['year_class_id']);
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

    public function out(SemesterStudent $semester_student)
    {
        check_admin($type=2);

        $att['at_school'] = "0";
        $semester_student->update($att);
        return redirect()->route('students.show',$semester_student->year_class_id);
    }

    public function rein(SemesterStudent $semester_student)
    {
        check_admin($type=2);

        $att['at_school'] = "1";
        $semester_student->update($att);
        return redirect()->route('students.show',$semester_student->year_class_id);
    }

}
