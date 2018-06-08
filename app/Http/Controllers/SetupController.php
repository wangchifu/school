<?php

namespace App\Http\Controllers;

use App\Setup;
use Illuminate\Http\Request;

class SetupController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $setup = Setup::first();
        $modules = ($setup->modules)?$setup->modules:"";
        $data = [
            'modules'=>$modules,
            'setup'=>$setup,
        ];
        return view('setups.index',$data);
    }

    public function add_img(Request $request)
    {

        //新增使用者的上傳目錄
        $new_path = 'public/title_image';


        //處理檔案上傳
        if ($request->hasFile('file')) {
            $file = $request->file('file');

                $info = [
                    //'mime-type' => $file->getMimeType(),
                    'original_filename' => $file->getClientOriginalName(),
                    'extension' => $file->getClientOriginalExtension(),
                    'size' => $file->getClientSize(),
                ];


                $file->storeAs($new_path, "title_image.jpg");

                $att['title_image'] = "1";

                $setup = Setup::first();
                $setup->update($att);

        }else{
            $words = "你沒有挑選檔案！！";
            return view('layouts.error',compact('words'));
        }



        return redirect()->route('setups.index');
    }

    public function del_img()
    {
        $att['title_image'] = null;

        $setup = Setup::first();
        $setup->update($att);
        unlink(storage_path('app/public/title_image/title_image.jpg'));
        return redirect()->route('setups.index');
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
    public function update(Request $request, Setup $setup)
    {
        $check = $request->input('check');
        $att['modules'] = "";
        foreach($check as $k=>$v){
            $att['modules'] .= $k.",";
        }
        $setup->update($att);
        return redirect()->route('setups.index');
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
