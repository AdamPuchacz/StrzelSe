<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Competition extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'description', 'date', 'location', 'created_by', 'max_participants', 'image_path'];

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function participants()
    {
        return $this->belongsToMany(User::class, 'competition_user', 'competition_id', 'user_id')->withTimestamps();
    }

    public function isFull(): bool
    {
        return $this->fresh()->participants()->count() >= $this->max_participants;
    }

}
