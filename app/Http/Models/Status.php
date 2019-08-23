<?php


namespace App\Http\Models;

/**
 * タスクのステータス
 * @package App\Http\Models
 */
interface Status
{
    public const TODO = '1';
    public const DOING = '2';
    public const DONE = '3';
}
