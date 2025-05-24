<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VerificationFile extends Model
{
    use HasFactory;

    protected $fillable = ['verification_request_id', 'path'];

    public function verificationRequest()
    {
        return $this->belongsTo(VerificationRequest::class);
    }
}
