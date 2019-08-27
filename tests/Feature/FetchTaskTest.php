<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * タスク検索のフィーチャーテスト
 * @package Tests\Feature
 */
class FetchTaskTest extends TestCase
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
                'dueDate' => '2019-08-18',
                'status' => '1',
            ],
            [
                'title' => 'テストタスク２',
                'description' => 'テストタスク２です',
                'dueDate' => '2019-09-18',
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
                'dueDate' => '2019-08-18',
                'status' => '1',
            ],
            [
                'title' => 'テストタスク２',
                'description' => 'テストタスク２です',
                'dueDate' => '2019-09-18',
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
            'dueDate' => '2019-09-18',
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
}
