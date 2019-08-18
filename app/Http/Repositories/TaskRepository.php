<?php


namespace App\Http\Repositories;


use Illuminate\Support\Collection;

interface TaskRepository
{
    /**
     * タスクの検索
     * @param  string|null  $title
     * @param  string|null  $description
     * @param  string|null  $dueDate
     * @param  string|null  $status
     * @return Collection
     */
    public function search(?string $title, ?string $description, ?string $dueDate, ?string $status): Collection;

    /**
     * タスクを全取得
     * @return Collection
     */
    public function fetchAll(): Collection;
}
