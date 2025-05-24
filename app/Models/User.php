<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable; // Dodaj HasApiTokens

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'role' => 'string',
        ];
    }

    /**
     * Relacja wiele-do-wielu z zawodami (Competition).
     */
    public function competitions()
    {
        return $this->belongsToMany(Competition::class, 'competition_user', 'user_id', 'competition_id')
            ->withTimestamps();
    }

    /**
     * Metoda pomocnicza do sprawdzania roli użytkownika.
     */
    public function hasRole($roles): bool
    {
        // Pobierz rolę użytkownika i upewnij się, że nie ma błędnych spacji
        $userRole = trim($this->role);

        // Jeśli sprawdzamy wiele ról, użyj in_array()
        if (is_array($roles)) {
            return in_array($userRole, $roles, true);
        }

        // Sprawdź pojedynczą rolę
        return $userRole === $roles;
    }

    /**
     * Sprawdza, czy użytkownik jest adminem lub zweryfikowanym użytkownikiem.
     */
    public function isVerifiedOrAdmin(): bool
    {
        return in_array($this->role, ['admin', 'verified']);
    }

    public function verificationRequest()
    {
        return $this->hasOne(VerificationRequest::class);
    }
}
