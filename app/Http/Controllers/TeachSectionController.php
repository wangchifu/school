<?php

namespace App\Http\Controllers;

use App\MonthSetup;
use App\SubstituteTeacher;
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
        return view('teach_sections.c_group');
    }

    public function support()
    {
        return view('teach_sections.support');
    }

    public function taxation()
    {
        return view('teach_sections.taxation');
    }

    public function over()
    {
        return view('teach_sections.over');
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
