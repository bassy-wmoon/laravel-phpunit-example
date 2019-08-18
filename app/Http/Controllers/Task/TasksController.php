<?php

namespace App\Http\Controllers\Task;

use App\Http\Controllers\Controller;
use App\Http\EloquentModels\Task;
use App\Http\Models\Task as Model;
use App\Http\Response\TasksGet;
use App\Http\Response\TasksIndex;
use App\Http\Service\TaskSearchService;
use Illuminate\Http\Request;

class TasksController extends Controller
{
    /**
     * タスクを検索する
     * @param  Request  $request
     * @param  TaskSearchService  $service
     * @return TasksIndex
     */
    public function index(Request $request, TaskSearchService $service)
    {
        // クエリパラメータを取得してコレクションに格納する
        $params = collect();
        $params->put('title', $request->query('title'));
        $params->put('description', $request->query('description'));
        $params->put('dueDate', $request->query('dueDate'));
        $params->put('status', $request->query('status'));

        // タスクを検索し、レスポンスクラスに変換する
        $results = $service($params);
        return new TasksIndex($results);
    }

    /**
     * IDに一致するタスクを取得する
     * @param  Request  $request
     * @param  Task  $task
     * @return TasksGet
     */
    public function get(Request $request, Task $task)
    {
        $task = $task->find($request->id);
        return new TasksGet(
            new Model($task->title, $task->description, $task->due_date, $task->status)
        );
    }
}
