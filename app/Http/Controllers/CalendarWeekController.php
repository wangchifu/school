<?php

namespace App\Http\Controllers;

use App\Calendar;
use App\CalendarWeek;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CalendarWeekController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //取學期選單
        $ss = DB::select('select semester from calendar_weeks group by semester');
        foreach($ss as $s){
            $semesters[$s->semester] = $s->semester;
        }
        rsort($semesters);

        $data = [
            'semesters'=>$semesters,
        ];
        return view('calendar_weeks.index',$data);
    }

    public function create($open_date)
    {
        $semester = get_date_semester($open_date);
        $open_date = explode('-',$open_date);
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
            'semester'=>$semester,
        ];

        return view('calendar_weeks.create',$data);
    }

    public function store(Request $request)
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

    public function destroy($semester)
    {
        CalendarWeek::where('semester',$semester)->delete();
        Calendar::where('semester',$semester)->delete();
        return redirect()->route('calendars.index');
    }

}
