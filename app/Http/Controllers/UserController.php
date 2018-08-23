<?php

namespace App\Http\Controllers;

use App\Group;
use App\Http\Requests\UserRequest;
use App\User;
use App\UserGroup;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::orderBy('disable')
            ->orderBy('order_by')->get();

        $data = [
            'users'=>$users,
        ];
        return view('users.index',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $groups = Group::where('disable','=',null)->pluck('name', 'id')->toArray();
        $default_group = null;
        $data = [
            'groups'=>$groups,
            'default_group'=>$default_group,
        ];
        return view('users.create',$data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserRequest $request)
    {
        $check_user = User::where('username',$request->input('username'))->first();

        if(!empty($check_user)){
            $words = "此帳號 ".$request->input('username')." 已有人使用了！";
            return view('layouts.error',compact('words'));
        }

        $att['username'] = $request->input('username');
        $att['password'] = bcrypt(env('DEFAULT_USER_PWD'));
        $att['name'] = $request->input('name');
        $att['job_title'] = $request->input('job_title');
        $att['order_by'] = $request->input('order_by');
        $att['email'] = $request->input('email');
        $att['website'] = $request->input('website');
        $att['disable'] = $request->input('disable');
        $user = User::create($att);

        $group_id = $request->input('group_id');

        //批次insert的array
        $all_insert = [];
        foreach($group_id as $k=>$v){
            $one = [
                'user_id'=>$user->id,
                'group_id'=>$v
            ];
            array_push($all_insert,$one);
        }
        UserGroup::insert($all_insert);

        return redirect()->route('users.index');
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
    public function edit(User $user)
    {
        $groups = Group::where('disable','=',null)->pluck('name', 'id')->toArray();

        $default_group = UserGroup::where('user_id',$user->id)->pluck('group_id')->toArray();

        $data = [
            'user'=>$user,
            'groups'=>$groups,
            'default_group'=>$default_group,
        ];
        return view('users.edit',$data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UserRequest $request, User $user)
    {
        $att['username'] = $request->input('username');
        $att['name'] = $request->input('name');
        $att['job_title'] = $request->input('job_title');
        $att['order_by'] = $request->input('order_by');
        $att['email'] = $request->input('email');
        $att['website'] = $request->input('website');
        $att['disable'] = $request->input('disable');
        $user->update($att);

        $group_id = $request->input('group_id');

        //全刪使用者群組資料
        UserGroup::where('user_id',$user->id)->delete();

        //再批次insert的array
        $all_insert = [];
        if(!empty($group_id)) {
            foreach ($group_id as $k => $v) {
                $one = [
                    'user_id' => $user->id,
                    'group_id' => $v
                ];
                array_push($all_insert, $one);
            }
            UserGroup::insert($all_insert);
        }

        return redirect()->route('users.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        //先刪群組對照表
        UserGroup::where('user_id',$user->id)->delete();
        //再刪使用者
        $user->delete();

        return redirect()->route('users.index');
    }

    public function users_resetPw(User $user)
    {
        $att['password'] = bcrypt(env('DEFAULT_USER_PWD'));
        $user->update($att);
        return redirect()->route('users.index');
    }

    public function users_allEdit()
    {
        $users = User::where('disable',null)
            ->orderBy('order_by')->get();

        $data = [
            'users'=>$users,
        ];
        return view('users.allEdit',$data);
    }

    public function users_allUpdate(Request $request)
    {
        $user_id = $request->input('user_id');
        $order_by = $request->input('order_by');
        $job_title = $request->input('job_title');
        foreach($user_id as $k=>$v){
            if(!isset($order_by[$k])) $order_by[$k]=null;
            $att['order_by'] = $order_by[$k];

            if(!isset($job_title[$k])) $job_title[$k]=null;
            $att['job_title'] = $job_title[$k];

            User::where('id',$v)->update($att);
        }
        return redirect()->route('users.index');
    }
}
