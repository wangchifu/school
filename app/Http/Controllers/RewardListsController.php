<?php

namespace App\Http\Controllers;

use App\Http\Requests\RewardListRequest;
use App\Reward;
use App\RewardList;
use App\Winner;
use Illuminate\Http\Request;

class RewardListsController extends Controller
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
    public function create(Reward $reward)
    {
        $reward_lists = RewardList::where('reward_id',$reward->id)
            ->orderBy('order_by')
            ->get();
        $data = [
            'reward'=>$reward,
            'reward_lists'=>$reward_lists,
        ];
        return view('reward_lists.create',$data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(RewardListRequest $request)
    {
        $att['order_by'] = $request->input('order_by');
        $att['title'] = $request->input('title');
        $att['description'] = $request->input('description');
        $att['reward_id'] = $request->input('reward_id');
        RewardList::create($att);
        return redirect()->route('reward_lists.create',$att['reward_id']);
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
    public function destroy(RewardList $reward_list)
    {
        if($reward_list->reward->user_id != auth()->user()->id){
            $words = "不是你的喔！";
            return view('layouts.error',compact('words'));
        }

        foreach($reward_list->winners as $winner){
            $winner->delete();
        }
        $reward_list->delete();
        return redirect()->route('reward_lists.create',$reward_list->reward_id);

    }
}
