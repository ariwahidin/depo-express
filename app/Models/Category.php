<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $guarded = [];

    public function scopeGetActiveCategories(Builder $query) : void
    {
        $query->where('delete_status', 'no')->orderByDesc('created_at');
    }
}
