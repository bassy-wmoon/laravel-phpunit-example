<?php


namespace App\Http\Service;


use App\Http\Repository\TaskRepository;
use Illuminate\Support\Collection;

class TaskSearchService
{
    private $repository;

    /**
     * TaskSearchService constructor.
     * @param $repository
     */
    public function __construct(TaskRepository $repository)
    {
        $this->repository = $repository;
    }

    public function __invoke(Collection $params): Collection
    {
        return $this->repository->search(
            $params->get('title'),
            $params->get('description'),
            $params->get('dueDate'),
            $params->get('status')
        );
    }
}