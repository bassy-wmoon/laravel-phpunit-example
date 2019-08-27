<?php

namespace Tests\Feature;

use Illuminate\Http\Response;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CreateTaskTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
    }

    /**
     * @test
     */
    public function タスクの新規作成に成功すると、ステータス302でタスクの検索へリダイレクトされること() {

        // パラメータ
        $params = [
            'title' => 'タスクタイトル',
            'description' => 'タスクの説明',
            'dueDate' => '2019-08-01'
        ];

        // テスト実行
        $response = $this->post('/tasks', $params);

        // 検証
        $response->assertStatus(Response::HTTP_FOUND);
        $response->assertRedirect('/tasks');
    }

    /**
     * @test
     */
    public function 必須パラメータが無い場合ステータス422が返却されること() {

        // パラメータ
        $params = [
            'title' => null,
            'description' => null,
            'dueDate' => null
        ];

        // テスト実行
        $response = $this->post('/tasks', $params);

        // 検証
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    /**
     * @test
     */
    public function 文字数オーバーの場合ステータス422が返却されること() {

        // パラメータ
        $params = [
            'title' => str_repeat('1', 51),
            'description' => str_repeat('1', 2049),
            'dueDate' => '2019/08/01'
        ];

        // テスト実行
        $response = $this->post('/tasks', $params);

        // 検証
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    /**
     * @test
     * @dataProvider 不正な日付パターン
     * @param $date
     */
    public function 日付が不正の場合ステータス422が返却されること($date) {

        // パラメータ
        $params = [
            'title' => 'test',
            'description' => 'test',
            'dueDate' => $date
        ];

        // テスト実行
        $response = $this->post('/tasks', $params);

        // 検証
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    public function 不正な日付パターン() {
        return [
          '文字列' => ['abc#$%&'],
          '数値' => [123],
          '配列' => [[1,2,3], ['a', 'b', 'c']],
          '真' => [true],
          '偽' => [false],
          '存在しない日付' => ['2019/13/32'],
          '存在しない日付2' => ['2019/02/29'],
          '存在しない日付3' => ['2020/02/30'],
          '存在しない日付4' => ['-1/01/01'],
        ];
    }
}
