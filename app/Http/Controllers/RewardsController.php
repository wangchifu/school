<?php

namespace App\Http\Controllers;

use App\Http\Requests\RewardRequest;
use App\Reward;
use Illuminate\Http\Request;

class RewardsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $rewards = Reward::orderBy('id','DESC')->paginate(10);
        $data = [
            'rewards'=>$rewards,
        ];
        return view('rewards.index',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('rewards.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(RewardRequest $request)
    {
        $att['name'] = $request->input('name');
        $att['description'] = $request->input('description');
        $att['disable'] = 1;
        $att['user_id'] = auth()->user()->id;
        Reward::create($att);

        return redirect()->route('rewards.index');
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
    public function destroy(Reward $reward)
    {
        foreach($reward->reward_lists as $reward_list){
            foreach($reward_list->winners as $winner){
                $winner->delete();
            }
            $reward_list->delete();
        }
        $reward->delete();
        return redirect()->route('rewards.index');
    }

    public function disable(Reward $reward)
    {
        if($reward->user_id != auth()->user()->id){
            $words = "不是你的喔！";
            return view('layouts.error',compact('words'));
        }

        $att['disable'] = ($reward->disable)?null:"1";
        $reward->update($att);
        return redirect()->route('rewards.index');
    }
}
