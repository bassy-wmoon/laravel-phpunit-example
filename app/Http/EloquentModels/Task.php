<?php

namespace App\Http\EloquentModels;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{

    public function scopeSearch($query, ?string $title, ?string $description, ?string $dueDate, ?string $status)
    {
        return $query
            ->when($title, function ($query, $title) {
                return $query->where('title', 'like', "%${title}%");
            })
            ->when($description, function ($query, $description) {
                return $query->where('description', 'like', "%${description}%");
            })
            ->when($dueDate, function ($query, $dueDate) {
                return $query->whereDueDate($dueDate);
            })
            ->when($status, function ($query, $status) {
                return $query->whereStatus($status);
            });
    }

    public function getDueDateAttribute($value)
    {
        return (new Carbon($value))->format('Y-m-d');
    }
}
