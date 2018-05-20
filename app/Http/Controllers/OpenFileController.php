<?php

namespace App\Http\Controllers;

use App\Http\Requests\UploadRequest;
use App\Upload;
use Illuminate\Http\Request;

class OpenFileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($path=null)
    {
        $has_dir = null;
        $on_folder = null;
        $folder_path[0] = '根目錄';

        $path_array = explode('&',$path);
        $folder_id = end($path_array);
        if(empty($folder_id)) $folder_id=null;

        //若在根目錄下查看使用者是否已有自己的目錄
        if(auth()->check()){
            if ($path == null) {
                $select = Upload::where('job_title', auth()->user()->job_title)
                    ->where('fun','1')
                    ->where('folder_id', null)
                    ->first();
                $has_dir = ($select) ? "1" : null;
            } else {
                $select = Upload::where('id', $folder_id)
                    ->where('fun','1')
                    ->where('type','1')
                    ->first();
                $has_dir = 1;
                $on_folder = ($select->job_title == auth()->user()->job_title)?$folder_id:null;
            }
        }


        foreach($path_array as $v){
            if($v != null){
                $check = Upload::where('id',$v)->first();
                $folder_path[$v] = $check->name;
            }
        }


        //列出目錄
        $folders = Upload::where('fun','1')
            ->where('type','1')
            ->where('folder_id',$folder_id)
            ->orderBy('order_by')
            ->get();

        //列出檔案
        $files = Upload::where('fun','1')
            ->where('type','2')
            ->where('folder_id',$folder_id)
            ->orderBy('order_by')
            ->get();




        $data = [
            'path'=>$path,
            'folder_id'=>$folder_id,
            'has_dir'=>$has_dir,
            'on_folder'=>$on_folder,
            'folders'=>$folders,
            'folder_path'=>$folder_path,
            'files'=>$files,
        ];
        return view('open_files.index',$data);
    }


    public function download($path)
    {
        $path_array = explode('&',$path);
        $file_id = end($path_array);

        $file = "open_files";
        foreach($path_array as $v){
            if($v != $file_id and !empty($v)){
                $check = Upload::where('id',$v)->first();
                $file .= "&".$check->name;
            }
        }

        $upload = Upload::where('id',$file_id)->first();
        $file .= '&'.$upload->name;

        return redirect('file/'.$file);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function create()
    {
        if(empty(auth()->user()->job_title)){
            $words = "你尚未有行政職稱！";
            return view('layouts.error',compact('words'));
        }
        //新增使用者的上傳目錄
        $folder = 'open_files/'.auth()->user()->job_title;
        if(!is_dir(storage_path('app/public/open_files'))) mkdir(storage_path('app/public/open_files'));

        if(!is_dir(storage_path('app/public/'.$folder))) mkdir(storage_path('app/public/'.$folder));


        $att['name'] = auth()->user()->job_title;
        $att['fun'] = 1;//公開文件
        $att['type'] = 1;//目錄
        $att['job_title'] = auth()->user()->job_title;
        $att['order_by'] = auth()->user()->order_by;
        Upload::create($att);
        return redirect()->route('open_files.index');
    }

    public function create_folder(Request $request)
    {
        if(empty($request->input('name'))){
            $words = "目錄名稱不能空白！！";
            return view('layouts.error',compact('words'));
        }

        //新增使用者的上傳目錄
        $new_path = 'app/public/open_files';
        //新增目錄
        foreach(explode('&',$request->input('path')) as $v){
            $check = Upload::where('id',$v)->first();
            if(!empty($v)) $new_path .= '/'.$check->name;
        }

        $new_path .= '/'.$request->input('name');

        if(!is_dir(storage_path($new_path))){
            mkdir(storage_path($new_path));
        }else{
            $words = "已有相同名稱的目錄！！";
            return view('layouts.error',compact('words'));
        }
        $att['name'] = $request->input('name');
        $att['fun'] = 1;//公開文件
        $att['type'] = 1;//目錄
        $att['job_title'] = auth()->user()->job_title;
        $att['folder_id'] = $request->input('folder_id');
        Upload::create($att);
        return redirect()->route('open_files.index',$request->input('path'));
    }

    public function upload_file(UploadRequest $request)
    {
        //新增使用者的上傳目錄
        $new_path = 'public/open_files';
        //新增目錄
        foreach(explode('&',$request->input('path')) as $v){
            $check = Upload::where('id',$v)->first();
            if(!empty($v)) $new_path .= '/'.$check->name;
        }



        //處理檔案上傳
        if ($request->hasFile('files')) {
            $files = $request->file('files');
            foreach($files as $file){
                $info = [
                    //'mime-type' => $file->getMimeType(),
                    'original_filename' => $file->getClientOriginalName(),
                    'extension' => $file->getClientOriginalExtension(),
                    'size' => $file->getClientSize(),
                ];

                if(file_exists(storage_path('app/'.$new_path.'/'.$info['original_filename']))){
                    $words = "相同名稱的檔案： ".$info['original_filename']." ！！";
                    return view('layouts.error',compact('words'));
                }

                $file->storeAs($new_path, $info['original_filename']);

                $att['name'] = $info['original_filename'];
                $att['fun'] = 1;//公開文件
                $att['type'] = 2;//檔案
                $att['job_title'] = auth()->user()->job_title;
                $att['folder_id'] = $request->input('folder_id');
                Upload::create($att);

            }
        }else{
            $words = "你沒有挑選檔案！！";
            return view('layouts.error',compact('words'));
        }



        return redirect()->route('open_files.index',$request->input('path'));

    }

    public function delete($path)
    {
        $path_array = explode('&',$path);
        $id = end($path_array);
        $check = Upload::where('id',$id)->first();
        if($check->job_title != auth()->user()->job_title){
            $words = "這不是你的文件！";
            return view('layouts.error',compact('words'));
        }

        $new_path = "";
        $remove = "open_files";

        foreach($path_array as $v){
            if(!empty($v) and $v != $id){
                $new_path .= '&'.$v;
            }
            if(!empty($v)){
                $f = Upload::where('id',$v)->first();
                $remove .= "/".$f->name;
            }
        }

        if($check->type == "1"){
            if(is_dir(storage_path('app/public/'.$remove))){
                rmdir(storage_path('app/public/'.$remove));
            }
        }elseif($check->type == "2"){
            if(file_exists(storage_path('app/public/'.$remove))){
                unlink(storage_path('app/public/'.$remove));
            }
        }

        $check->delete();




        return redirect()->route('open_files.index',$new_path);
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
