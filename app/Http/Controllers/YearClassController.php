<?php

namespace App\Http\Controllers;

use App\Http\Requests\YearClassRequest;
use App\YearClass;
use Illuminate\Http\Request;

class YearClassController extends Controller
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
    public function create()
    {
        return view('year_classes.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(YearClassRequest $request)
    {
        $att = [];
        $r = $request->all();

        $check = YearClass::where('semester',$r['semester'])->first();
        if(!empty($check)){
            $words = "該學期已有班級，請先清空再新增！";
            return view('layouts.error',compact('words'));
        }


        if($r['class1'] > 0){
            for ( $i=1 ; $i<=$r['class1'] ; $i++ ) {
                $att['semester'] = $r['semester'];
                $att['year_class'] = "1".sprintf("%02s",$i);
                $att['name'] = "一年".$i."班";
                YearClass::create($att);

            }
        }
        if($r['class2'] > 0){
            for ( $i=1 ; $i<=$r['class2'] ; $i++ ) {
                $att['semester'] = $r['semester'];
                $att['year_class'] = "2".sprintf("%02s",$i);
                $att['name'] = "二年".$i."班";
                YearClass::create($att);

            }
        }
        if($r['class3'] > 0){
            for ( $i=1 ; $i<=$r['class3'] ; $i++ ) {
                $att['semester'] = $r['semester'];
                $att['year_class'] = "3".sprintf("%02s",$i);
                $att['name'] = "三年".$i."班";
                YearClass::create($att);

            }
        }
        if($r['class4'] > 0){
            for ( $i=1 ; $i<=$r['class4'] ; $i++ ) {
                $att['semester'] = $r['semester'];
                $att['year_class'] = "4".sprintf("%02s",$i);
                $att['name'] = "四年".$i."班";
                YearClass::create($att);

            }
        }
        if($r['class5'] > 0){
            for ( $i=1 ; $i<=$r['class5'] ; $i++ ) {
                $att['semester'] = $r['semester'];
                $att['year_class'] = "5".sprintf("%02s",$i);
                $att['name'] = "五年".$i."班";
                YearClass::create($att);

            }
        }
        if($r['class6'] > 0){
            for ( $i=1 ; $i<=$r['class6'] ; $i++ ) {
                $att['semester'] = $r['semester'];
                $att['year_class'] = "6".sprintf("%02s",$i);
                $att['name'] = "六年".$i."班";
                YearClass::create($att);

            }
        }
        if($r['class9'] > 0){
            for ( $i=1 ; $i<=$r['class9'] ; $i++ ) {
                $att['semester'] = $r['semester'];
                $att['year_class'] = "9".sprintf("%02s",$i);
                $att['name'] = "特教".$i."班";
                YearClass::create($att);

            }
        }

        return redirect()->route('students.index');

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
