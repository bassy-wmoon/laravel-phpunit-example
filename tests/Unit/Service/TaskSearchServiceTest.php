<?php

namespace Tests\Unit\Service;

use App\Http\Repository\TaskRepository;
use App\Http\Service\TaskSearchService;
use Tests\TestCase;

class TaskSearchServiceTest extends TestCase
{
    /**
     * @test
     */
    public function 検索条件が１つでもある場合、searchが呼び出される()
    {
        // リポジトリのモック作成
        $mock = \Mockery::mock(TaskRepository::class);
        $mock->shouldReceive('search')
            ->once();
        $mock->shouldNotReceive('fetchAll');
        $this->instance(TaskRepository::class, $mock);

        // テストパラメータ作成
        $params = collect([
            'title' => 'タイトル'
        ]);

        // テスト対象のインスタンス作成
        $testTarget = $this->app->make(TaskSearchService::class);

        // テスト実行
        $testTarget($params);
    }

    /**
     * @test
     */
    public function 検索条件が無い場合、fetchAllが呼び出される()
    {
        // リポジトリのモック作成
        $mock = \Mockery::mock(TaskRepository::class);
        $mock->shouldReceive('fetchAll')
            ->once();
        $mock->shouldNotReceive('search');
        $this->instance(TaskRepository::class, $mock);

        // テストパラメータ作成
        $params = collect([]);

        // テスト対象のインスタンス作成
        $testTarget = $this->app->make(TaskSearchService::class);

        // テスト実行
        $testTarget($params);
    }
}
