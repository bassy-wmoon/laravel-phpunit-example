<?php

namespace App\Http\Controllers\Task;

use App\Http\Controllers\Controller;
use App\Http\EloquentModels\Task;
use App\Http\Models\Status;
use App\Http\Models\Task as Model;
use App\Http\Requests\CreateTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Http\Response\TasksGet;
use App\Http\Response\TasksIndex;
use App\Http\Service\TaskSearchService;
use Carbon\Carbon;
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
        $task = $task->findOrFail($request->id);
        return new TasksGet(
            new Model($task->title, $task->description, $task->due_date, $task->status)
        );
    }

    /**
     * タスクを新規作成する
     *
     * @param  CreateTaskRequest  $request
     * @param  Task  $task
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function create(CreateTaskRequest $request, Task $task)
    {
        $task->title = $request->title;
        $task->description = $request->description;
        $task->due_date = new Carbon($request->dueDate);
        $task->status = Status::TODO;
        $task->save();

        return redirect('/tasks');
    }

    /**
     * タスクを更新する
     *
     * @param  UpdateTaskRequest  $request
     * @param  Task  $task
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Exception
     */
    public function update(UpdateTaskRequest $request, Task $task)
    {
        $task = $task->find($request->id);
        $task->title = $request->title;
        $task->description = $request->description;
        $task->due_date = new Carbon($request->dueDate);
        $task->status = $request->status;
        $task->save();

        return redirect('/tasks');
    }
}
