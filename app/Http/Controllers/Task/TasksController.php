<?php

namespace App\Http\Controllers\Task;

use App\Http\Controllers\Controller;
use App\Model\Task;
use Illuminate\Http\Request;

class TasksController extends Controller
{
    /**
     * タスクを一覧表示する
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $tasks = Task::all();
        $tasks->map(function ($task){
           return [
               'title' => $task->title,
               'description' => $task->description,
               'dueDate' => $task->due_date,
               'status' => $task->status,
           ];
        });
        return view('tasks.index', ['tasks' => $tasks]);
    }
}
