<?php

namespace App\Http\Controllers;

use App\MonthSetup;
use App\OriSub;
use App\SubstituteTeacher;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
        $semester = get_semester();
        /*
        $ms = DB::table('month_setups')
            ->select(DB::raw('semester'))
            ->groupBy('semester')
            ->get();
        $semesters = [];
        foreach($ms as $m){
            $semesters[$m->semester] = $m->semester;
        }
        */

        $types=[
            'winter_summer'=>'寒(暑)假',
            'holiday'=>'國定假日',
            'typhoon'=>'颱風假',
        ];

        $month_setups = MonthSetup::where('semester',$semester)
            ->orderBy('event_date')
            ->get();


        $data = [
            'types'=>$types,
            'semester'=>$semester,
            //'semesters'=>$semesters,
            'month_setups'=>$month_setups
        ];
        return view('teach_sections.month_setup',$data);
    }

    public function month_setup_store(Request $request)
    {
        $start = $request->input('holiday1');
        $stop = $request->input('holiday2');

        $att['semester'] = $request->input('semester');
        $att['type'] = $request->input('type');
        $dt1 =  Carbon::createFromFormat('Y-m-d', $start);
        $dt2 =  Carbon::createFromFormat('Y-m-d', $stop);

        do{
            if($dt1->isWeekday()){
                $att['event_date'] = substr($dt1->toDateTimeString(),0,10);
                MonthSetup::create($att);
            }
            $dt1->addDay();
        }while($dt2->gte($dt1));

        return redirect()->route('month_setup.index');
    }

    public function month_setup_store2(Request $request)
    {
        $att['semester'] = $request->input('semester');
        $att['type'] = "workday";

        $att['event_date'] = $request->input('workday1');
        $att['another_date'] = $request->input('workday2');

        MonthSetup::create($att);

        return redirect()->route('month_setup.index');
    }

    public function month_setup_destroy(MonthSetup $month_setup)
    {
        $month_setup->delete();
        return redirect()->route('month_setup.index');
    }

    public function c_group()
    {
        $select_users = User::where('disable',null)
            ->orderBy('order_by')
            ->pluck('name','id')
            ->toArray();

        $semester= get_semester();

        $ori_subs = OriSub::where('semester',$semester)
            ->where('type','c_group')
            ->get();


        $data = [
            'select_users'=>$select_users,
            'semester'=>$semester,
            'ori_subs'=>$ori_subs,
        ];

        return view('teach_sections.c_group',$data);
    }

    public function c_group_store(Request $request)
    {
        $att['semester'] = $request->input('semester');
        $att['type'] = $request->input('type');
        $att['ori_teacher'] = $request->input('ori_teacher');
        $att['sub_teacher'] = $request->input('sub_teacher');
        $att['ps'] = $request->input('ps');

        $sub1 = $request->input('sub1');
        $sub2 = $request->input('sub2');
        $sub3 = $request->input('sub3');
        $sub4 = $request->input('sub4');
        $sub5 = $request->input('sub5');
        $s = 0;
        for($i=1;$i<8;$i++){
            if(empty($sub1[$i])){
                $sub[1][$i] = null;
            }else{
                $sub[1][$i] = "on";
                $s++;
            }
        }

        for($i=1;$i<8;$i++){
            if(empty($sub2[$i])){
                $sub[2][$i] = null;
            }else{
                $sub[2][$i] = "on";
                $s++;
            }
        }

        for($i=1;$i<8;$i++){
            if(empty($sub3[$i])){
                $sub[3][$i] = null;
            }else{
                $sub[3][$i] = "on";
                $s++;
            }
        }

        for($i=1;$i<8;$i++){
            if(empty($sub4[$i])){
                $sub[4][$i] = null;
            }else{
                $sub[4][$i] = "on";
                $s++;
            }
        }

        for($i=1;$i<8;$i++){
            if(empty($sub5[$i])){
                $sub[5][$i] = null;
            }else{
                $sub[5][$i] = "on";
                $s++;
            }
        }

        $att['sections'] = serialize($sub);
        $att['section'] = $s;

        OriSub::create($att);
        return redirect()->route('c_group.index');
    }

    public function c_group_show(OriSub $ori_sub)
    {
        $data = [
            'ori_sub'=>$ori_sub,
        ];

        return view('teach_sections.c_group_show',$data);
    }

    public function c_group_report()
    {
        $semester= get_semester();
        $data = [
            'semester'=>$semester
        ];
        return view('teach_sections.c_group_report1',$data);
    }

    public function c_group_send_report(Request $request)
    {
        $semester= get_semester();
        $start_date = $request->input('start_date');
        $stop_date = $request->input('stop_date');

        $money = $request->input('money');
        $title = $request->input('title');

        $ori_subs = OriSub::where('semester',$semester)
            ->where('type','c_group')
            ->get();

        $month_setups = MonthSetup::where('semester',$semester)
            ->get();
        foreach($month_setups as $month_setup){
            $special_date[$month_setup->event_date]['type'] = $month_setup->type;
            $special_date[$month_setup->event_date]['another_date'] = $month_setup->another_date;
        }

        foreach($ori_subs as $ori_sub){
            $dt1 =  Carbon::createFromFormat('Y-m-d', $start_date);
            $dt2 =  Carbon::createFromFormat('Y-m-d', $stop_date);
            if(empty($total_sections[$ori_sub->id])) $total_sections[$ori_sub->id] = 0;
            $sections = unserialize($ori_sub->sections);

            do{
                $d1 = substr($dt1->toDateTimeString(),0,10);

                $w = get_date_w($d1);
                //查看當日是否有上課
                if(empty($special_date[$d1]['type'])) $special_date[$d1]['type']=null;

                //如果是null...不是winter_summer 及 holiday，就是工作日
                if($special_date[$d1]['type'] == null ){
                    //當日的每一節是否有課
                    if(!empty($sections[$w])) {
                        foreach ($sections[$w] as $k => $v) {
                            if ($v == "on") {
                                $total_sections[$ori_sub->id]++;
                            }
                        }
                    }
                }
                //如果是workday補上課日，要補上課的節數
                if($special_date[$d1]['type'] == 'workday' ){
                    $another_date = $special_date[$d1]['another_date'];
                    $w2 = get_date_w($another_date);
                    foreach ($sections[$w2] as $k => $v) {
                        if ($v == "on") {
                            $total_sections[$ori_sub->id]++;
                        }
                    }
                }



                //該代課老師，是否有請假
                $sub_abs = OriSub::where('semester',$semester)
                    ->where('type','teacher_abs')
                    ->where('ori_teacher',$ori_sub->sub_teacher)
                    ->where('abs_date',$d1)
                    ->first();

                if(!empty($sub_abs)){
                    $abs_sections = unserialize($sub_abs->sections);
                    $w2 = get_date_w($d1);
                    foreach ($sections[$w2] as $k => $v) {
                        if ($v == "on" and $abs_sections[$k]=="on") {
                            $total_sections[$ori_sub->id]--;
                        }
                    }
                }


                $dt1->addDay();
            }while($dt2->gte($dt1));

        }

        $data = [
            'semester'=>$semester,
            'title'=>$title,
            'money'=>$money,
            'start_date'=>$start_date,
            'stop_date'=>$stop_date,
            'ori_subs'=>$ori_subs,
            'total_sections'=>$total_sections,
        ];

        return view('teach_sections.c_group_report2',$data);
    }

    public function c_group_print(Request $request)
    {
        $title = $request->input('title');

        $tea = $request->input('tea');
        $set_date = $request->input('set_date');
        $section = $request->input('section');
        $total_sections = $request->input('total_sections');
        $money = $request->input('money');
        $ori_money = $request->input('ori_money');
        $laubo = $request->input('laubo');
        $zenbo = $request->input('zenbo');
        $laute = $request->input('laute');
        $real_money = $request->input('real_money');
        $ps = $request->input('ps');


        $data = [
            'title'=>$title,
            'tea'=>$tea,
            'set_date'=>$set_date,
            'section'=>$section,
            'total_sections'=>$total_sections,
            'money'=>$money,
            'ori_money'=>$ori_money,
            'laubo'=>$laubo,
            'zenbo'=>$zenbo,
            'laute'=>$laute,
            'real_money'=>$real_money,
            'ps'=>$ps,
        ];
        return view('teach_sections.c_group_print',$data);
    }

    public function c_group_delete(OriSub $ori_sub)
    {
        $ori_sub->delete();
        return redirect()->route('c_group.index');
    }


    public function support()
    {
        return view('teach_sections.support');
    }

    public function taxation()
    {
        return view('teach_sections.taxation');
    }

    public function short()
    {
        return view('teach_sections.short');
    }

    public function over()
    {
        return view('teach_sections.over');
    }

    public function teacher_abs()
    {
        $select_users = User::where('disable',null)
            ->orderBy('order_by')
            ->pluck('name','id')
            ->toArray();

        $semester= get_semester();

        $substitute_teachers = SubstituteTeacher::where('active','1')
            ->pluck('teacher_name','id')
            ->toArray();

        $ori_subs = OriSub::where('semester',$semester)
            ->where('type','teacher_abs')
            ->get();

        $data = [
            'select_users'=>$select_users,
            'substitute_teachers'=>$substitute_teachers,
            'semester'=>$semester,
            'ori_subs'=>$ori_subs,
        ];

        return view('teach_sections.teacher_abs',$data);
    }

    public function teacher_abs_store(Request $request)
    {
        $att['semester'] = $request->input('semester');
        $att['type'] = $request->input('type');
        $att['ori_teacher'] = $request->input('ori_teacher');
        $att['sub_teacher'] = $request->input('sub_teacher');
        $att['ps'] = $request->input('ps');
        $att['abs_date'] = $request->input('abs_date');

        $sub = $request->input('sub');
        $s = 0;
        for($i=1;$i<8;$i++){
            if(empty($sub[$i])){
                $sub[$i] = null;
            }else{
                $sub[$i] = "on";
                $s++;
            }
        }

        $att['sections'] = serialize($sub);
        $att['section'] = $s;

        OriSub::create($att);
        return redirect()->route('teacher_abs.index');
    }

    public function teacher_abs_show(OriSub $ori_sub)
    {
        $data = [
            'ori_sub'=>$ori_sub,
        ];

        return view('teach_sections.teacher_abs_show',$data);
    }

    public function teacher_abs_delete(OriSub $ori_sub)
    {
        $ori_sub->delete();
        return redirect()->route('teacher_abs.index');
    }

    public function teacher_abs_report()
    {
        $semester= get_semester();
        $data = [
            'semester'=>$semester
        ];
        return view('teach_sections.teacher_abs_report1',$data);
    }

    public function teacher_abs_send_report(Request $request)
    {
        $semester = get_semester();
        $start_date = str_replace('-','',$request->input('start_date'));
        $stop_date = str_replace('-','',$request->input('stop_date'));

        $money = $request->input('money');
        $title = $request->input('title');

        $ori_subs = OriSub::where('semester',$semester)
            ->where('type','teacher_abs')
            ->orderBy('sub_teacher')
            ->get();
        $abs_data = [];
        $last_name = "";
        foreach($ori_subs as $ori_sub){
            if(str_replace('-','',$ori_sub->abs_date) >= $start_date and str_replace('-','',$ori_sub->abs_date) <= $stop_date){

                $ori_teacher = User::where('id',$ori_sub->ori_teacher)->first();
                $sub_teacher = SubstituteTeacher::where('id',$ori_sub->sub_teacher)->first();
                $teacher_name = $sub_teacher->teacher_name;
                if($teacher_name != $last_name){
                    $i = 1;
                }
                $abs_data[$teacher_name][$i]['ori_teacher'] = $ori_teacher->name;
                $abs_data[$teacher_name][$i]['sub_teacher'] = $sub_teacher->teacher_name;
                $abs_data[$teacher_name][$i]['abs_date'] = $ori_sub->abs_date;
                $abs_data[$teacher_name][$i]['ps'] = $ori_sub->ps;
                $abs_data[$teacher_name][$i]['section'] = $ori_sub->section;
                $last_name = $teacher_name;
                $i++;
                /**
                $abs_data[$ori_sub->id]['ori_teacher'] = $ori_teacher->name;
                $abs_data[$ori_sub->id]['sub_teacher'] = $sub_teacher->teacher_name;
                $abs_data[$ori_sub->id]['abs_date'] = $ori_sub->abs_date;
                $abs_data[$ori_sub->id]['ps'] = $ori_sub->ps;
                $abs_data[$ori_sub->id]['section'] = $ori_sub->section;
                 * */
            }

        }

        foreach($abs_data as $k=>$v){
            foreach($v as $k1=>$v1){
                if(empty($total_section[$k])) $total_section[$k] = 0;
                $total_section[$k] += $v1['section'];
            }
        }


        $data = [
            'money'=>$money,
            'title'=>$title,
            'abs_data'=>$abs_data,
            'total_section'=>$total_section,
        ];

        return view('teach_sections.teacher_abs_report2',$data);

    }

    public function teacher_abs_print(Request $request)
    {
        $title = $request->input('title');

        $sub_tea = $request->input('sub_tea');
        $abs_date = $request->input('abs_date');
        $ori_tea = $request->input('ori_tea');
        $ps = $request->input('ps');
        $section = $request->input('section');
        $money = $request->input('money');
        $ori_money = $request->input('ori_money');
        $ori_total_money = $request->input('ori_total_money');
        $laubo = $request->input('laubo');
        $zenbo = $request->input('zenbo');
        $real_money = $request->input('real_money');

        $data = [
            'title'=>$title,
            'sub_tea'=>$sub_tea,
            'abs_date'=>$abs_date,
            'ori_tea'=>$ori_tea,
            'ps'=>$ps,
            'section'=>$section,
            'money'=>$money,
            'ori_money'=>$ori_money,
            'ori_total_money'=>$ori_total_money,
            'laubo'=>$laubo,
            'zenbo'=>$zenbo,
            'real_money'=>$real_money,

        ];
        return view('teach_sections.teacher_abs_print',$data);
    }


    public function class_teacher()
    {

        return view('teach_sections.class_teacher');
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
