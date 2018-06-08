<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostRequest;
use App\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::orderBy('created_at','DESC')
            ->paginate(20);
        return view('posts.index',compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('posts.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PostRequest $request)
    {

        //處理檔案上傳
        if ($request->hasFile('title_image')) {
            $title_image = $request->file('title_image');
                $info = [
                    //'mime-type' => $file->getMimeType(),
                    //'original_filename' => $title_image->getClientOriginalName(),
                    //'extension' => $title_image->getClientOriginalExtension(),
                    //'size' => $file->getClientSize(),
                ];

            $att['title_image'] = 1;
        }

        $att['title'] = $request->input('title');
        $att['content'] = $request->input('content');
        $att['job_title'] = auth()->user()->job_title;
        $att['user_id'] = auth()->user()->id;
        $att['views'] = 0;
        $att['insite'] = $request->input('insite');

        $post = Post::create($att);
        $folder = 'posts/'.$post->id;

        //執行上傳檔案
        if ($request->hasFile('title_image')) {
            $title_image->storeAs('public/' . $folder, 'title_image.png');


            $src = storage_path('app/public/'.$folder.'/title_image.png');
            $img_file = imagecreatefromstring(file_get_contents($src));

            list($width,$height,$type,$attr)=getimagesize($src);


//裁剪开区域左上角的点的坐标
            $x = 0;
            $y = 0;
//裁剪区域的宽和高
            $height = round($width*3/7);
//最终保存成图片的宽和高，和源要等比例，否则会变形
            $final_width = $width;
            $final_height = $height;

//将裁剪区域复制到新图片上，并根据源和目标的宽高进行缩放或者拉升
            $new_image = imagecreatetruecolor($final_width, $final_height);
            imagecopyresampled($new_image, $img_file, 0, 0, $x, $y, $final_width, $final_height, $width, $height);

//输出图片
            imagejpeg($new_image, $src);

            imagedestroy($img_file);
            imagedestroy($new_image);


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

                $file->storeAs('public/' . $folder, $info['original_filename']);

            }
        }



        return redirect()->route('posts.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {

        $s_key = "pv".$post->id;
        if(!session($s_key)){
            $att['views'] = $post->views+1;
            $post->update($att);
        }
        session([$s_key => '1']);


        $next_post = Post::where('id', '>', $post->id)->first();
        $last_post = Post::where('id', '<', $post->id)
            ->orderBy('id','DESC')
            ->first();

        $last_id = (empty($last_post))?null:$last_post->id;
        $next_id = (empty($next_post))?null:$next_post->id;

        //有無附件
        $files = get_files(storage_path('app/public/posts/'.$post->id));

        $hot_posts = Post::orderBy('views','DESC')
            ->paginate(10);

        $data = [
            'post'=>$post,
            'hot_posts'=>$hot_posts,
            'last_id'=>$last_id,
            'next_id'=>$next_id,
            'files'=>$files,
        ];

        return view('posts.show',$data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        if(auth()->user()->id != $post->user_id){
            $words = "你想做什麼！？";
            return view('layouts.error',compact('words'));
        }

        //有無標題圖片
        $title_image = file_exists(storage_path('app/public/posts/'.$post->id.'/title_image.png'));

        //有無附件
        $files = get_files(storage_path('app/public/posts/'.$post->id));


        $data = [
            'post'=>$post,
            'files'=>$files,
            'title_image'=>$title_image,
        ];

     return view('posts.edit',$data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(PostRequest $request,Post $post)
    {
        if(auth()->user()->id != $post->user_id){
            $words = "你想做什麼！？";
            return view('layouts.error',compact('words'));
        }

        //處理檔案上傳
        if ($request->hasFile('title_image')) {
            $title_image = $request->file('title_image');
            $info = [
                //'mime-type' => $file->getMimeType(),
                //'original_filename' => $title_image->getClientOriginalName(),
                //'extension' => $title_image->getClientOriginalExtension(),
                //'size' => $file->getClientSize(),
            ];

            $att['title_image'] = 1;
        }

        $att['title'] = $request->input('title');
        $att['content'] = $request->input('content');
        $att['insite'] = $request->input('insite');

        $post->update($att);

        $folder = 'posts/'.$post->id;

        //執行上傳檔案
        if ($request->hasFile('title_image')) {
            $title_image->storeAs('public/' . $folder, 'title_image.png');

            $src = storage_path('app/public/'.$folder.'/title_image.png');
            $img_file = imagecreatefromstring(file_get_contents($src));

            list($width,$height,$type,$attr)=getimagesize($src);


//裁剪开区域左上角的点的坐标
            $x = 0;
            $y = 0;
//裁剪区域的宽和高
            $height = round($width/2);
//最终保存成图片的宽和高，和源要等比例，否则会变形
            $final_width = $width;
            $final_height = $height;

//将裁剪区域复制到新图片上，并根据源和目标的宽高进行缩放或者拉升
            $new_image = imagecreatetruecolor($final_width, $final_height);
            imagecopyresampled($new_image, $img_file, 0, 0, $x, $y, $final_width, $final_height, $width, $height);

//输出图片
            imagejpeg($new_image, $src);

            imagedestroy($img_file);
            imagedestroy($new_image);
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

                $file->storeAs('public/' . $folder, $info['original_filename']);

            }
        }


        return redirect()->route('posts.show',$post->id);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        if(auth()->user()->id != $post->user_id){
            $words = "你想做什麼！？";
            return view('layouts.error',compact('words'));
        }
        $folder = storage_path('app/public/posts/'.$post->id);
        if (is_dir($folder)) {
            if ($handle = opendir($folder)) { //開啟現在的資料夾
                while (false !== ($file = readdir($handle))) {
                    //避免搜尋到的資料夾名稱是false,像是0
                    if ($file != "." && $file != "..") {
                        //去除掉..跟.
                        unlink($folder.'/'.$file);
                    }
                }
                closedir($handle);
            }
            rmdir($folder);
        }

        $post->delete();

        return redirect()->route('posts.index');

    }

    public function fileDel($file)
    {
        $file_array = explode('&',$file);

        $post = Post::where('id',$file_array[1])->first();
        if($post->user_id != auth()->user()->id){
            $words = "你想做什麼？";
            return view('layouts.error',compact('words'));
        }

        $file = str_replace('&','/',$file);
        $file = storage_path('app/public/'.$file);
        if(file_exists($file)){
            unlink($file);
        }

        if($file_array[2] == "title_image.png"){
            $post = Post::where('id',$file_array[1])->first();
            $att['title_image'] = null;
            $post->update($att);
        }

        return redirect()->route('posts.edit',$file_array[1]);

    }

    public function search(Request $request)
    {
        $search = $request->input('search');

        if(mb_strlen($search) < 2){
            $words = "搜尋字元至少要二個字！";
            return view('layouts.error',compact('words'));
        }
        if($request->input('type')=="content"){
            $posts = Post::where('content','like','%'.$search.'%')->orderBy('id','DESC')->get();
        }else{
            $posts = Post::where('title','like','%'.$search.'%')->orderBy('id','DESC')->get();
        }

        $data = [
            'posts'=>$posts,
            'search'=>$search,
        ];
        return view('posts.search',$data);
    }

    public function job_title($job_title)
    {
        $posts = Post::where('job_title',$job_title)->orderBy('id','DESC')->paginate(20);
        $data = [
            'posts'=>$posts,
            'job_title'=>$job_title,
        ];
        return view('posts.job_title',$data);
    }

}
