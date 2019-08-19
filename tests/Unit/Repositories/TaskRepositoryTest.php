<?php

namespace Tests\Unit;

use App\Http\Models\Task;
use App\Http\Repositories\TaskRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TaskRepositoryTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
        $this->seed('TestTasksSeeder');
    }

    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function testExample()
    {
        $this->assertTrue(true);
    }

    /**
     * @test
     * @dataProvider 検索結果ありパターン
     */
    public function searchで検索条件に一致するタスクが取得できること($title, $description, $dueDate, $status, $expected)
    {
        // リポジトリクラスをインスタンス化し、テスト実行
        $testTarget = $this->app->make(TaskRepository::class);
        $actual = $testTarget->search($title, $description, $dueDate, $status);

        // 結果検証
        $this->assertEquals($expected, $actual);
    }

    /**
     * 検索結果ありのデータパターン
     * @return array
     */
    public function 検索結果ありパターン()
    {
        $expected1 = new Task(
            'テストタスク１',
            'テストタスク１です',
            '2019/08/18',
            '1'
        );
        $expected2 = new Task(
            'テストタスク２',
            'テストタスク２です',
            '2019/09/18',
            '2'
        );

        return [
            // title, description, dueDate, status, expected
            ['テストタスク１', null, null, null, collect([$expected1])], // title完全一致
            [null, 'テストタスク１です', null, null, collect([$expected1])], // description完全一致
            [null, null, '2019/08/18',null, collect([$expected1])], // dueDate一致
            [null, null, null, '1', collect([$expected1])], // status一致
            ['タスク２', null, null, null, collect([$expected2])], // title部分一致
            [null, 'タスク２', null, null, collect([$expected2])], // description部分一致
            ['タスク', null, null, null, collect([$expected1, $expected2])], // title部分一致
            [null, 'テスト', null, null, collect([$expected1, $expected2])],// description部分一致
            ['テスト', 'テスト', '2019/09/18', '2', collect([$expected2])], // パラメータ全部あり
            [null, null, null, null, collect([$expected1, $expected2])], // パラメータ全部なし
        ];
    }


    /**
     * @test
     * @dataProvider 検索結果なしパターン
     */
    public function searchで検索条件に一致しない場合0件のタスクが取得できること($title, $description, $dueDate, $status)
    {
        // リポジトリクラスをインスタンス化し、テスト実行
        $testTarget = $this->app->make(TaskRepository::class);
        $actual = $testTarget->search($title, $description, $dueDate, $status);

        // 結果検証
        $this->assertCount(0, $actual);
    }

    /**
     * 検索結果なしのデータパターン
     * @return array
     */
    public function 検索結果なしパターン()
    {
        return [
            // title, description, dueDate, status
            ['hoge', null, null, null],
            [null, 'hoge', null, null],
            [null, null, '2019/12/31', null],
            [null, null, null, '9'],
            ['hoge', 'hoge', '2019/12/31', '9'],
        ];
    }

    /**
     * @test
     */
    public function fetchAllで全件取得できること()
    {
        // 期待値
        $expected = collect([
            new Task(
                'テストタスク１',
                'テストタスク１です',
                '2019/08/18',
                '1'
            ),
            new Task(
                'テストタスク２',
                'テストタスク２です',
                '2019/09/18',
                '2'
            )
        ]);

        // テスト実行
        $testTarget = $this->app->make(TaskRepository::class);
        $actual = $testTarget->fetchAll();

        // 結果検証
        $this->assertEquals($expected, $actual);
    }

}
