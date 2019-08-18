<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Pagination\LengthAwarePaginator;
use Tests\TestCase;

class TasksHttpTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
        $this->seed('TestTasksSeeder');
    }

    /**
     * @test
     */
    public function 検索条件ありの場合タスクが取得できること()
    {
        // パラメータ
        $title = urlencode('テスト');

        // 期待値
        $expected = [
            [
                'title' => 'テストタスク１',
                'description' => 'テストタスク１です',
                'dueDate' => '2019/08/18',
                'status' => '1',
            ],
            [
                'title' => 'テストタスク２',
                'description' => 'テストタスク２です',
                'dueDate' => '2019/09/18',
                'status' => '2',
            ],
        ];

        // テスト実行
        $response = $this->get("/tasks?title=$title");

        // 結果検証
        $response->assertStatus(200);
        $response->assertViewIs('tasks.index');
        $response->assertViewHas('tasks', $expected);
    }

    /**
     * @test
     */
    public function 検索条件なしの場合タスクが全件取得できること()
    {
        // 期待値
        $expected = [
            [
                'title' => 'テストタスク１',
                'description' => 'テストタスク１です',
                'dueDate' => '2019/08/18',
                'status' => '1',
            ],
            [
                'title' => 'テストタスク２',
                'description' => 'テストタスク２です',
                'dueDate' => '2019/09/18',
                'status' => '2',
            ],
        ];

        // テスト実行
        $response = $this->get('/tasks');

        // 結果検証
        $response->assertStatus(200);
        $response->assertViewIs('tasks.index');
        $response->assertViewHas('tasks', $expected);
    }

    /**
     * @test
     */
    public function IDに一致するタスクが取得できること()
    {
        // 期待値
        $expected = [
            'title' => 'テストタスク２',
            'description' => 'テストタスク２です',
            'dueDate' => '2019/09/18',
            'status' => '2',
        ];

        // テスト実行
        $response = $this->get('/tasks/2');

        // 結果検証
        $response->assertStatus(200);
        $response->assertViewIs('tasks.show');
        $response->assertViewHas('task', $expected);
    }

    /**
     * @test
     */
    public function IDに一致しない場合404が返却されること()
    {
        // テスト実行
        $response = $this->get('/tasks/100');

        // 結果検証
        $response->assertStatus(404);
    }


    /**
     * @test
     */
    public function 検索条件ありの場合タスクが取得できること_ver2()
    {
        // パラメータ
        $title = urlencode('テスト');

        // テスト実行
        $response = $this->get("/task-fetch?title=$title");

        // 結果検証
        $response->assertStatus(200);
        $response->assertViewIs('tasks.index');
        $response->assertViewHas('text', 'hello world');

        // tasksはモデルのコレクションなのでクロージャー内で検証する
        $response->assertViewHas('tasks', function ($tasks) {
            $this->assertCount(2, $tasks);

            $actual1 = $tasks->get(0);
            $this->assertEquals('テストタスク１', $actual1->title);
            $this->assertEquals('テストタスク１です', $actual1->description);
            $this->assertEquals('2019/08/18', $actual1->due_date);
            $this->assertEquals('1', $actual1->status);

            $actual2 = $tasks->get(1);
            $this->assertEquals('テストタスク２', $actual2->title);
            $this->assertEquals('テストタスク２です', $actual2->description);
            $this->assertEquals('2019/09/18', $actual2->due_date);
            $this->assertEquals('2', $actual2->status);

            return true;
        });

        // ページネーションのレスポンス確認
        var_dump($response->viewData('tasks2'));

        // tasks2はページネーターなのでクロージャー内で検証する
        $response->assertViewHas('tasks2', function (LengthAwarePaginator $tasks) {
            // 現在ページのデータ件数
            $this->assertEquals(2, $tasks->total());
            // 現在ページ
            $this->assertEquals(1, $tasks->currentPage());
            // 最終ページ
            $this->assertEquals(1, $tasks->lastPage());
            // データの件数
            $this->assertCount(2, $tasks);

            // データの検証
            // LengthAwarePaginator型なのだがHigherOrderCollectionProxyのおかげでコレクションの操作ができるらしい
            $actual1 = $tasks->get(0);
            $this->assertEquals('テストタスク１', $actual1->title);
            $this->assertEquals('テストタスク１です', $actual1->description);
            $this->assertEquals('2019/08/18', $actual1->due_date);
            $this->assertEquals('1', $actual1->status);

            $actual2 = $tasks->get(1);
            $this->assertEquals('テストタスク２', $actual2->title);
            $this->assertEquals('テストタスク２です', $actual2->description);
            $this->assertEquals('2019/09/18', $actual2->due_date);
            $this->assertEquals('2', $actual2->status);

            return true;
        });
    }
}
