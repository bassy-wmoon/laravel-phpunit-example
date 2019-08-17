<?php

namespace App\EloquentModels;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{

    public function scopeSearch($query, string $title, string $description, string $dueDate, string $status)
    {
        return $query
            ->when($title, function ($query, $title) {
                return $query->where('title', 'like', "%${title}%");
            })
            ->when($description, function ($query, $description) {
                return $query->where('description', 'like', "%${description}%");
            })
            ->when($dueDate, function ($query, $dueDate) {
                return $query->where('due_date', 'like', "%${dueDate}%");
            })
            ->when($status, function ($query, $status) {
                return $query->where('status', 'like', "%${status}%");
            });
    }
}
