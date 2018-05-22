<?php

namespace App\Http\Controllers;

use App\Fun;
use App\SemesterStudent;
use App\Student;
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
                        if($YearClass->semester_students->count() != 0){
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

        $data = [
            'student_admin'=>$student_admin,
            'semesters'=>$semesters,
            'semester'=>$semester,
            'year_class'=>$year_class,
            'all_student'=>$all_student,
            'students_data'=>$students_data,
            'out_students'=>$out_students,
            'YearClasses'=>$YearClasses,
        ];
        return view('students.index',$data);
    }


    public function import(Request $request)
    {
        $this->check_admin();

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

                    $att['name'] = $value['姓名'];
                    $att['sex'] = $value['性別'];

                    $has_student = Student::where('sn', '=', $value['學號'])->first();
                    if ($has_student) {
                        $has_student->update($att);
                        $id = $has_student->id;
                    } else {
                        $att['sn'] = $value['學號'];
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
        $this->check_admin();
        SemesterStudent::where('semester',$semester)->delete();
        return redirect()->route('students.index');
    }

    public function clear_all($semester)
    {
        $this->check_admin();
        SemesterStudent::where('semester',$semester)->delete();

        YearClass::where('semester',$semester)->delete();

        return redirect()->route('students.index');
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

    public function check_admin()
    {
        //type=2是學生系統
        $check_admin = Fun::where('user_id',auth()->user()->id)
            ->where('type','2')
            ->first();
        $student_admin = (empty($check_admin))?"0":"1";
        if($student_admin == "0"){
            $words = "你不是管理者！";
            return view('layouts.error',compact('words'));
        }
    }

}
