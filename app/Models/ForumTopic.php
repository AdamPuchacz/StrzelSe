<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ForumTopic extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['title', 'content', 'image', 'category_id', 'user_id', 'is_edited', 'deleted_by'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class, 'topic_id')->withTrashed()->latest();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
