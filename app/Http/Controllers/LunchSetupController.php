<?php

namespace App\Http\Controllers;

use App\Http\Requests\LunchSetupRequest;
use App\LunchSetup;
use Illuminate\Http\Request;

class LunchSetupController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $admin = check_admin(3);

        $lunch_setups = LunchSetup::orderBy('semester','DESC')
            ->paginate(10);
        $data = [
            'admin'=>$admin,
            'lunch_setups'=>$lunch_setups,
        ];
        return view('lunch_setups.index',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('lunch_setups.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(LunchSetupRequest $request)
    {
        $att['semester'] = $request->input('semester');
        $att['tea_money'] = $request->input('tea_money');
        $att['stud_money'] = $request->input('stud_money');
        $att['stud_back_money'] = $request->input('stud_back_money');
        $att['support_part_money'] = $request->input('support_part_money');
        $att['support_all_money'] = $request->input('support_all_money');
        $att['die_line'] = $request->input('die_line');
        $att['stud_gra_date'] = $request->input('stud_gra_date');
        $att['tea_open'] = ($request->input('tea_open')=="on")?"1":null;
        $att['disable'] = ($request->input('disable')=="on")?"1":null;

        $att['place'] = null;
        foreach($request->input('place') as $v){
            $att['place'] .= $v.",";
        }
        $att['place'] = substr($att['place'],0,-1);

        $att['factory'] = null;
        foreach($request->input('factory') as $v){
            $att['factory'] .= $v.",";
        }
        $att['factory'] = substr($att['factory'],0,-1);

        LunchSetup::create($att);
        return redirect()->route('lunch_setups.index');
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
