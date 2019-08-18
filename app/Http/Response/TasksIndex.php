<?php


namespace App\Http\Response;

use App\Http\Models\Task as Model;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Support\Collection;

class TasksIndex implements Responsable
{
    /** @var Collection */
    private $tasks;

    /**
     * Task constructor.
     * @param  Collection  $models
     */
    public function __construct(Collection $models)
    {
        $this->tasks = $models;
    }

    /**
     * Create an HTTP response that represents the object.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function toResponse($request)
    {
        $response = $this->tasks->map(function (Model $task) {
            return [
                'title' => $task->getTitle(),
                'description' => $task->getDescription(),
                'dueDate' => $task->getDueDate(),
                'status' => $task->getStatus(),
            ];
        });
        return view('tasks.index', ['tasks' => $response]);
    }
}
