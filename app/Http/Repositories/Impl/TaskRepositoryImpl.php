<?php


namespace App\Http\Repositories\Impl;


use App\Http\EloquentModels\Task;
use App\Http\Repositories\TaskRepository;
use Illuminate\Support\Collection;
use App\Http\Models\Task as Model;

class TaskRepositoryImpl implements TaskRepository
{
    /** @var Task  */
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
        $tasks = $this->task
            ->search($title, $description, $dueDate, $status)
            ->orderBy('id')
            ->get();
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

    /**
     * Eloquentモデルからモデルのコレクションに変換する
     * @param $tasks
     * @return Collection
     */
    private function convertToModel($tasks)
    {
        return collect(
            $tasks->map(function ($task) {
                return new Model(
                    $task->title,
                    $task->description,
                    $task->due_date,
                    $task->status
                );
            })
        );
    }
}
