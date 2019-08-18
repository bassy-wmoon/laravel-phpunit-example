<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class TestTasksSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     * @throws Exception
     */
    public function run()
    {
        DB::table('tasks')->insert([
            [
                'title' => 'テストタスク１',
                'description' => 'テストタスク１です',
                'due_date' => (new Carbon('2019/08/18'))->format('Y/m/d'),
                'status' => '1',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'title' => 'テストタスク２',
                'description' => 'テストタスク２です',
                'due_date' => (new Carbon('2019/09/18'))->format('Y/m/d'),
                'status' => '2',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]
        ]);
    }
}
