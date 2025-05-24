<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VerificationRequest extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'first_name', 'last_name', 'phone', 'region', 'status'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function files()
    {
        return $this->hasMany(VerificationFile::class);
    }

    public function isPending()
    {
        return $this->status === 'pending';
    }

    public function isApproved()
    {
        return $this->status === 'approved';
    }

    public function isRejected()
    {
        return $this->status === 'rejected';
    }

    public function getTranslatedStatusAttribute()
    {
        return match ($this->status) {
            'pending' => 'Oczekuje',
            'approved' => 'Zaakceptowany',
            'rejected' => 'Odrzucony',
            default => 'Nieznany status',
        };
    }
}
