<?php

namespace App\Providers;

use App\Http\Repository\Impl\TaskRepositoryImpl;
use App\Http\Repository\TaskRepository;
use Illuminate\Support\ServiceProvider;

/**
 * RepositoryProvider
 *
 * Repositoryのインターフェースと実装クラスを結合する
 * @package App\Providers
 */
class RepositoryProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(TaskRepository::class, TaskRepositoryImpl::class);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
