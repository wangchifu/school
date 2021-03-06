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
        $att['open_date'] = $request->input('open_date');
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
            if($has_report==0) {
                $has_report = (auth()->user()->id == $report->user_id) ? "1" : "0";
            }
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
        $meeting->update($request->all());
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

    public function txtDown(Meeting $meeting)
    {
        $filename = $meeting->open_date."_".$meeting->name.".txt";
        $txtDown = $meeting->open_date."_".$meeting->name."\r\n";
        foreach($meeting->reports as $report){
            $txt = "●".$report->job_title." ".$report->user->name."\r\n".$report->content."\r\n \r\n";
            $ori[$report->order_by] = $txt;
        }
        ksort($ori);
        foreach($ori as $k=>$v){
            $txtDown .= $v;
        }
        header("Content-disposition: attachment;filename=$filename");
        header("Content-type: text/text ; Charset=utf8");
        header("Pragma: no-cache");
        header("Expires: 0");
        echo $txtDown;
    }
}
