<?php

use Illuminate\Database\Seeder;

class SetupsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Setup::truncate();  //清空資料庫

        \App\Setup::create([
            'modules'=>'meetings,school_plans,tests,classroom_orders,fixes,students,lunches,sports,rewards',
            'views'=>'0',
        ]);
    }
}
