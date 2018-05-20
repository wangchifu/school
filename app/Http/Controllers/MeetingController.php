<?php

namespace App\Http\Controllers;

use App\Http\Requests\MeetingRequest;
use App\Meeting;
use App\Report;
use Illuminate\Http\Request;

class MeetingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $meetings = Meeting::orderBy('id','DESC')->paginate(20);
        $data = [
            'meetings'=>$meetings,
        ];
        return view('meetings.index',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('meetings.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(MeetingRequest $request)
    {
        $date = explode('/',$request->input('open_date'));
        $att['open_date'] = $date[2].'-'.$date[0].'-'.$date[1];
        $att['name'] = $request->input('name');
        $check_meeting = Meeting::where('open_date',$att['open_date'])->where('name',$att['name'])->first();
        if(!empty($check_meeting)){
            $words = "該日已有相同名稱的會議了！";
            return view('layouts.error',compact('words'));
        }

        Meeting::create($att);
        return redirect()->route('meetings.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Meeting $meeting)
    {
        $reports = Report::where('meeting_id',$meeting->id)
            ->orderBy('order_by')
            ->get();

        $has_report = 0;
        foreach($reports as $report){
            $has_report = (auth()->user()->id == $report->user_id)?"1":"0";
        }

        $open_date = str_replace('-','',$meeting->open_date);
        $die_line = (date('Ymd') > $open_date)?"1":"0";

        $data = [
            'meeting'=>$meeting,
            'reports'=>$reports,
            'has_report'=>$has_report,
            'die_line'=>$die_line,
        ];
        return view('meetings.show',$data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Meeting $meeting)
    {
        return view('meetings.edit',compact('meeting'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(MeetingRequest $request, Meeting $meeting)
    {
        $date = explode('/',$request->input('open_date'));
        $att['open_date'] = $date[2].'-'.$date[0].'-'.$date[1];
        $att['name'] = $request->input('name');
        $meeting->update($att);
        return redirect()->route('meetings.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Meeting $meeting)
    {
        $meeting->delete();
        return redirect()->route('meetings.index');
    }
}
