<?php


namespace App\Http\Response;


use App\Http\Models\Task;
use Illuminate\Contracts\Support\Responsable;

class TasksGet implements Responsable
{
    /** @var Task  */
    private $task;

    /**
     * TasksGet constructor.
     * @param $task
     */
    public function __construct(Task $task)
    {
        $this->task = $task;
    }

    /**
     * Create an HTTP response that represents the object.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function toResponse($request)
    {
        $response = [
            'title' => $this->task->getTitle(),
            'description' => $this->task->getDescription(),
            'dueDate' => $this->task->getDueDate(),
            'status' => $this->task->getStatus(),
        ];
        return view('tasks.show', ['task' => $response]);
    }
}
