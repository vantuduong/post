<?php

namespace App\Models;

use App\ModelFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use ModelFilter;

    protected $guarded = [];

    protected $filters = [
        'user_id',
        'title',
        'status'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getStatusNameAttribute()
    {
        return $this->status ? 'Published' : 'Unpublished';
    }

    public function filterCreatedAt(Builder $builder, $value)
    {
        $builder->whereDate('created_at', $value);
    }
}
