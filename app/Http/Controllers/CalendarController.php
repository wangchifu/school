<?php

namespace App\Http\Controllers;

use App\Calendar;
use App\CalendarWeek;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CalendarController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->semester = get_semester();
    }

    public function index()
    {
        $calendar_week = CalendarWeek::where('semester',$this->semester)->first();
        if(empty($calendar_week)){
            $has_week = null;
            $calendar_weeks = [];
        }else {
            $has_week = 1;
            $calendar_weeks = CalendarWeek::where('semester',$this->semester)
                ->orderBy('week')
                ->get();
        }
        $data = [
            'has_week'=>$has_week,
            'calendar_weeks'=>$calendar_weeks
        ];
        return view('calendars.index',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $calendar_week = CalendarWeek::where('semester',$this->semester)->first();
        if(empty($calendar_week)){
            $words = "管理者尚未設定週次！";
            return view('layouts.error',compact('words'));
        }else{
            $calendar_weeks = CalendarWeek::where('semester',$this->semester)
                ->orderBy('week')
                ->get();
            $data = [
                'calendar_weeks'=>$calendar_weeks,
                'semester'=>$this->semester,
            ];
            return view('calendars.create',$data);
        }

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $calendar_weeks = CalendarWeek::where('semester',$this->semester)
            ->orderBy('week')
            ->get();

        $all = [];
        foreach($calendar_weeks as $calendar_week){
            $content = $request->input('w'.$calendar_week->week.'_content');
            foreach($content as $v){
                if(!empty($v)){
                    $att['calendar_week_id'] = $calendar_week->id;
                    $att['semester'] = $request->input('semester');
                    $att['calendar_kind'] = $request->input('calendar_kind');
                    $att['content'] = $v;
                    $att['user_id'] = auth()->user()->id;
                    $att['job_title'] = auth()->user()->job_title;
                    $att['order_by'] = auth()->user()->order_by;

                    $one = [
                        'calendar_week_id'=>$att['calendar_week_id'],
                        'semester'=>$att['semester'],
                        'calendar_kind'=>$att['calendar_kind'],
                        'content'=>$att['content'],
                        'user_id'=>$att['user_id'],
                        'job_title'=>$att['job_title'],
                        'order_by'=>$att['order_by'],
                        'created_at'=>now(),
                        'updated_at'=>now(),
                    ];

                    array_push($all,$one);
                }
            }
        }

        Calendar::insert($all);

        return redirect()->route('calendars.index');

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

    public function week_create(Request $request)
    {
        $open_date = explode('-',$request->input('open_date'));
        $knownDate = Carbon::create($open_date[0], $open_date[1], $open_date[2], 00);
        Carbon::setTestNow($knownDate);
        $dt = new Carbon('last sunday');

        $w = 1;
        $d = 0;

        do{
            $start_end[$w][$d] = $dt->toDateString();
            $d = 6;
            $start_end[$w][$d] = $dt->addDay(6)->toDateString();
            $dt->addDay();
            $w++;
            $d = 0;
        }while($w < 23);

        $data = [
            'start_end'=>$start_end,
            'semester'=>$this->semester,
        ];
        return view('calendars.week_create',$data);
    }

    public function week_store(Request $request)
    {
        $semester = $request->input('semester');
        $all = [];
        foreach($request->input('week') as $k => $v){
            if(!empty($v)){
                $start_end = $request->input('start_end');
                $att['week'] = $v;
                $att['semester'] = $semester;
                $att['start_end'] = $start_end[$k];
                $one = [
                    'semester'=>$att['semester'],
                    'week'=>$att['week'],
                    'start_end'=>$att['start_end'],
                    'created_at'=>now(),
                    'updated_at'=>now(),
                ];

                array_push($all,$one);
            }

        }

        CalendarWeek::insert($all);

        return redirect()->route('calendars.index');
    }

    public function week_delete()
    {
        CalendarWeek::where('semester',$this->semester)->delete();
        Calendar::where('semester',$this->semester)->delete();
        return redirect()->route('calendars.index');
    }
}
