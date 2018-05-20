<?php

use Illuminate\Database\Seeder;

class GroupsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Group::truncate();  //清空資料庫
        $data = [
            ['name'=>'行政人員'],
            ['name'=>'級任老師'],
            ['name'=>'科任老師'],
            ['name'=>'校長室'],
            ['name'=>'教務處'],
            ['name'=>'學務處'],
            ['name'=>'總務處'],
            ['name'=>'輔導處'],
            ['name'=>'人事室'],
            ['name'=>'會計室'],
        ];

        \App\Group::insert($data);
    }
}
