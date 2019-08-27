<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class TasksSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('tasks')->insert([
            [
                'title' => 'タスク1',
                'description' => 'このタスクはサンプルです１',
                'due_date' => Carbon::now()->format('Y-m-d'),
                'status' => '1',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'title' => 'タスク2',
                'description' => 'このタスクはサンプルです２',
                'due_date' => Carbon::now()->format('Y-m-d'),
                'status' => '2',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]
        ]);
    }
}
