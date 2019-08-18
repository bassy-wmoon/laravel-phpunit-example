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

    /**
     * 検索条件でタスクを検索する
     * 検索条件が無い場合、タスクを全件取得する
     * @param  Collection  $params
     * @return Collection
     */
    public function __invoke(Collection $params): Collection
    {
        if ($params->get('title') ||
            $params->get('description') ||
            $params->get('dueDate') ||
            $params->get('status'))
        {
            return $this->repository->search(
                $params->get('title'),
                $params->get('description'),
                $params->get('dueDate'),
                $params->get('status')
            );
        }
        return $this->repository->fetchAll();
    }
}
