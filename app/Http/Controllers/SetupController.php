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
        //有無附件
        $files = get_files(storage_path('app/public/title_image/random'));

        $data = [
            'modules'=>$modules,
            'setup'=>$setup,
            'files'=>$files,
        ];
        return view('setups.index',$data);
    }

    public function add_logo(Request $request)
    {

        //新增使用者的上傳目錄
        $new_path = 'public/title_image';


        //處理檔案上傳
        if ($request->hasFile('logo')) {
            $logo = $request->file('logo');

            $info = [
                //'mime-type' => $file->getMimeType(),
                'original_filename' => $logo->getClientOriginalName(),
                'extension' => $logo->getClientOriginalExtension(),
                'size' => $logo->getClientSize(),
            ];


            $logo->storeAs($new_path, 'logo.ico');


        }else{
            $words = "你沒有挑選檔案！！";
            return view('layouts.error',compact('words'));
        }



        return redirect()->route('setups.index');
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

                $filename = explode('.',$info['original_filename']);

                $att['title_image'] = $filename[0];

                $setup = Setup::first();
                $setup->update($att);

        }else{
            $words = "你沒有挑選檔案！！";
            return view('layouts.error',compact('words'));
        }



        return redirect()->route('setups.index');
    }

    public function add_imgs(Request $request)
    {

        //新增使用者的上傳目錄
        $new_path = 'public/title_image/random';

        $old_files = get_files(storage_path('app/public/title_image/random'));

        $n = count($old_files);

        //處理檔案上傳
        if ($request->hasFile('files')) {
            $files = $request->file('files');
            foreach($files as $file){
                $n++;
                $info = [
                    //'mime-type' => $file->getMimeType(),
                    'original_filename' => $file->getClientOriginalName(),
                    'extension' => $file->getClientOriginalExtension(),
                    'size' => $file->getClientSize(),
                ];
                $filename = sprintf("%03s",$n)."-".$info['original_filename'];

                $file->storeAs($new_path, $filename);
            }
        }



        return redirect()->route('setups.index');
    }

    public function del_img($type,$filename)
    {
        if($type=="title_image"){
            $att['title_image'] = null;
            $setup = Setup::first();
            $setup->update($att);
        }else{
            $file = "random/".$filename;
        }
        unlink(storage_path('app/public/title_image/'.$file));
        return redirect()->route('setups.index');
    }

    public function nav_color(Request $request,Setup $setup)
    {
        $nav_color = $request->input('color');
        $att['nav_color'] = "";
        foreach($nav_color as $v){
            $att['nav_color'] .= $v.",";
        }
        $setup->update($att);
        return redirect()->route('setups.index');
    }

    public function nav_default()
    {
        $setup = Setup::first();
        $att['nav_color'] = null;
        $setup->update($att);
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
