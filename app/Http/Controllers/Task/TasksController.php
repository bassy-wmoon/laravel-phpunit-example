<?php

namespace App\Http\Controllers\Task;

use App\EloquentModels\Task;
use App\Http\Controllers\Controller;
use App\Http\Service\TaskSearchService;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

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

    /**
     * タスクを検索する
     * @param  Request  $request
     * @param  TaskSearchService  $service
     */
    public function search(Request $request, TaskSearchService $service)
    {
        $params = collect();
        $params->put('title', $request->query('title'));
        $params->put('description', $request->query('description'));
        $params->put('dueDate', $request->query('dueDate'));
        $params->put('status', $request->query('status'));

        $result = $service($params);
    }
}
