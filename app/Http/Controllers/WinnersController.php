<?php

namespace App\Http\Controllers;

use App\Reward;
use App\SemesterStudent;
use App\Student;
use App\Winner;
use App\YearClass;
use Illuminate\Http\Request;

class WinnersController extends Controller
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
    public function create(Reward $reward,$select_year_class=null)
    {
        $semester = get_semester();
        $year_classes = get_class_menu($semester);

        $list_data = [];
        //$default_class = null;
        $semester_students = [];
        $students = [];

        if(empty($select_year_class)){
            $year_class = YearClass::where('semester',$semester)
                ->where('user_id',auth()->user()->id)->first();

            $select_year_class = (!empty($year_class))?$year_class->year_class:null;
            if($select_year_class){
                $semester_students = SemesterStudent::where('year_class_id',$year_class->id)
                    ->orderBy('num')
                    ->get();
            }
        }else{
            $year_class = YearClass::where('semester',$semester)
                ->where('year_class',$select_year_class)->first();

            $semester_students = SemesterStudent::where('year_class_id',$year_class->id)
                ->orderBy('num')
                ->get();
        }

        foreach($semester_students as $semester_student){
            $students[$semester_student->student_id]['num'] = $semester_student->num;
            $students[$semester_student->student_id]['name'] = $semester_student->student->name;
        }



        foreach($reward->reward_lists as $list){
            $list_data[$list->order_by][$list->id]['title'] = $list->title;
            $list_data[$list->order_by][$list->id]['description'] = $list->description;
        }
        ksort($list_data);
        $data=[
            'reward'=>$reward,
            'list_data'=>$list_data,
            'year_classes'=>$year_classes,
            'select_year_class'=>$select_year_class,
            'students'=>$students,
        ];
        return view('winners.create',$data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $att['reward_list_id'] = $request->input('reward_list_id');
        $att['reward_id'] = $request->input('reward_id');
        $att['user_id'] = auth()->user()->id;
        $att['year_class'] = $request->input('year_class');
        $att['student_id'] = $request->input('student_id');
        $student = Student::where('id',$att['student_id'])->first();
        $att['name'] = $student->name;

        Winner::create($att);
        return redirect()->route('winners.create',['reward'=>$att['reward_id'],'select_year_class'=>$att['year_class']]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Reward $reward)
    {
        $list1=[];
        $lists=[];
        $winners=[];
        $has_classes = [];
        foreach($reward->reward_lists as $reward_list){
            $list1[$reward_list->order_by][$reward_list->id]['title'] = $reward_list->title;
        }
        ksort($list1);
        foreach($list1 as $k=>$v){
            foreach($v as $k1=>$v1){
                $lists[$k1] = $v1;
            }
        }


        foreach($reward->winners as $winner){
            $winners[$winner->year_class][$winner->reward_list_id]['name'] = $winner->name;
            $winners[$winner->year_class][$winner->reward_list_id]['teacher'] = $winner->user->name;
            $has_classes[$winner->year_class] = 1;
        }
        ksort($winners);
        ksort($has_classes);

        $data = [
            'reward'=>$reward,
            'lists'=>$lists,
            'winners'=>$winners,
            'has_classes'=>$has_classes,
        ];
        return view('winners.show',$data);
    }

    public function print(Reward $reward)
    {
        $list1=[];
        $lists=[];
        $winners=[];
        $has_classes = [];
        foreach($reward->reward_lists as $reward_list){
            $list1[$reward_list->order_by][$reward_list->id]['title'] = $reward_list->title;
            $list1[$reward_list->order_by][$reward_list->id]['description'] = $reward_list->description;
        }
        ksort($list1);
        foreach($list1 as $k=>$v){
            foreach($v as $k1=>$v1){
                $lists[$k1] = $v1;
            }
        }


        foreach($reward->winners as $winner){
            $winners[$winner->year_class][$winner->reward_list_id]['name'] = $winner->name;
            $winners[$winner->year_class][$winner->reward_list_id]['teacher'] = $winner->user->name;
            $has_classes[$winner->year_class] = 1;
        }
        ksort($winners);
        ksort($has_classes);

        $data = [
            'reward'=>$reward,
            'lists'=>$lists,
            'winners'=>$winners,
            'has_classes'=>$has_classes,
        ];
        return view('winners.print',$data);
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
    public function destroy(Winner $winner)
    {
        if($winner->user_id != auth()->user()->id){
            $words = "你要做什麼？";
            return view('layouts.error',compact('words'));
        }

        $winner->delete();

        return redirect()->route('winners.create',['reward'=>$winner->reward_id,'select_year_class'=>$winner->year_class]);
    }
}
