<?php

namespace App\Http\Controllers\Task;

use App\Http\EloquentModels\Task;
use App\Http\Models\Task as Model;
use App\Http\Controllers\Controller;
use App\Http\Response\Task as Response;
use App\Http\Service\TaskSearchService;
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
        $tasks = $tasks->map(function ($task){
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
     * @return Response
     */
    public function search(Request $request, TaskSearchService $service)
    {
        // クエリパラメータを取得してコレクションに格納する
        $params = collect();
        $params->put('title', $request->query('title'));
        $params->put('description', $request->query('description'));
        $params->put('dueDate', $request->query('dueDate'));
        $params->put('status', $request->query('status'));

        // タスクを検索し、レスポンスクラスに変換する
        $results = $service($params);
        return new Response($results);
    }
}
