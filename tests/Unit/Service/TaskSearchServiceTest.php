<?php

namespace Tests\Unit\Service;

use App\Http\Repositories\TaskRepository;
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

        // searchメソッドが1回呼び出されることの検証
        $mock->shouldReceive('search')
            ->once();

        // fetchAllメソッドが呼び出されないことの検証
        $mock->shouldNotReceive('fetchAll');

        // モックをインスタンス化
        $this->instance(TaskRepository::class, $mock);

        // テストパラメータ作成
        $params = collect([
            'title' => 'タイトル'
        ]);

        // テスト対象のインスタンス作成
        $testTarget = $this->app->make(TaskSearchService::class);

        // テスト実行&検証
        $testTarget($params);
    }

    /**
     * @test
     */
    public function 検索条件が無い場合、fetchAllが呼び出される()
    {
        // リポジトリのモック作成
        $mock = \Mockery::mock(TaskRepository::class);

        // fetchAllメソッドが1回呼び出されることの検証
        $mock->shouldReceive('fetchAll')
            ->once();
        // searchメソッドが呼び出されないことの検証
        $mock->shouldNotReceive('search');

        // モックをインスタンス化
        $this->instance(TaskRepository::class, $mock);

        // テストパラメータ作成
        $params = collect([]);

        // テスト対象のインスタンス作成
        $testTarget = $this->app->make(TaskSearchService::class);

        // テスト実行&検証
        $testTarget($params);
    }
}
