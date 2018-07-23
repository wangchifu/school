<?php

namespace App\Http\Controllers;

use App\Content;
use App\Http\Requests\UserRequest;
use App\Link;
use App\Post;
use App\Setup;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::orderBy('created_at','DESC')
            ->paginate(15);

        //$users = User::where('disable',null)->orderBy('order_by')->get();

        //$contents = Content::all();
        //$open_contents = [];
        //foreach($contents as  $content){
        //    $open_contents[$content->title] = $content->content;
        //}

        $setup = Setup::first();

        $data = [
            'posts'=>$posts,
            //'open_contents'=>$open_contents,
            //'users'=>$users,
            'setup'=>$setup,
        ];
        return view('index',$data);
    }

    public function userData()
    {
        return view('auth.userData');
    }

    public function userData_resetPw(Request $request)
    {
        if(!password_verify($request->input('old_password'), auth()->user()->password)){
            $words = "舊密碼錯誤！你不是本人！？";
            return view('layouts.error',compact('words'));
        }
        if($request->input('password') != $request->input('password_confirm')){
            $words = "兩次新密碼不相同";
            return view('layouts.error',compact('words'));
        }
        if(empty($request->input('password'))){
            $words = "新密碼不得為空！";
            return view('layouts.error',compact('words'));
        }


        $att['id'] = auth()->user()->id;
        $att['password'] = bcrypt($request->input('password'));
        $user = User::where('id',$att['id'])->first();
        $user->update($att);
        return redirect()->route('index');
    }

    public function userData_update(UserRequest $request)
    {

        $user = User::where('id',auth()->user()->id)->first();
        $user->update($request->all());
        return redirect()->route('index');
    }

    public function getImg($path)
    {
        $path = str_replace('&','/',$path);
        $path = storage_path('app/public/'.$path);
        $file = File::get($path);
        $type = File::mimeType($path);

        $response = Response::make($file, 200);
        $response->header("Content-Type", $type);
        return $response;
    }

    public function getFile($file)
    {
        $file = str_replace('&','/',$file);
        $file = storage_path('app/public/'.$file);
        return response()->download($file);
    }

    public function getPublicFile($file)
    {
        $file = str_replace('&','/',$file);
        $file = public_path($file);
        return response()->download($file);
    }

    public function teachers_link()
    {
        $users = User::where('disable',null)->orderBy('order_by')->get();
        $data = [
            'users'=>$users,
        ];
        return view('teachers_link');
    }



}
