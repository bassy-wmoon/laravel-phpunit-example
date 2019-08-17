<?php


namespace App\Http\Repository;


use Illuminate\Support\Collection;

interface TaskRepository
{
    function search(?string $title, ?string $description, ?string $dueDate, ?string $status): Collection;
}
