<?php

namespace Tests\Feature;

use Illuminate\Http\Response;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CreateTaskTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testExample()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
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
        $response = $this->post('/tasks');

        // 検証
        $response->assertStatus(Response::HTTP_FOUND);
        $response->assertRedirect('/tasks');
    }
}
