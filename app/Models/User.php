<?php

namespace App\Models;

use App\Enums\UserRole;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'role' => UserRole::class,
        ];
    }

    // OOP Helper Methods
    public function isAdmin(): bool
    {
        return $this->role === UserRole::ADMIN;
    }

    public function isTradesman(): bool
    {
        return $this->role === UserRole::TRADESMAN;
    }

    public function isUser(): bool
    {
        return $this->role === UserRole::USER;
    }

    // Relationships
    public function repairRequests(): HasMany
    {
        return $this->hasMany(RepairRequest::class, 'user_id');
    }

    public function assignedJobs(): HasMany
    {
        return $this->hasMany(RepairRequest::class, 'tradesman_id');
    }
}
