<?php


namespace App\Http\Repository\Impl;


use App\Http\EloquentModels\Task;
use App\Http\Repository\TaskRepository;
use Illuminate\Support\Collection;
use App\Http\Models\Task as Model;

class TaskRepositoryImpl implements TaskRepository
{
    private $task;

    /**
     * TaskRepositoryImpl constructor.
     * @param $task
     */
    public function __construct(Task $task)
    {
        $this->task = $task;
    }

    /**
     * @inheritDoc
     */
    public function search(?string $title, ?string $description, ?string $dueDate, ?string $status): Collection
    {
        $tasks = $this->task->search($title, $description, $dueDate, $status)->get();
        return $this->convertToModel($tasks);
    }

    /**
     * @inheritDoc
     */
    public function fetchAll(): Collection
    {
        $tasks = $this->task->all();
        return $this->convertToModel($tasks);
    }

    private function convertToModel($tasks)
    {
        return $tasks->map(function ($task) {
            return new Model(
                $task->title,
                $task->description,
                $task->due_date,
                $task->status
            );
        });
    }
}
