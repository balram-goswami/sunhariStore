<?php

namespace App\Models;

use App\Models\Enums\UserRoles;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Laravel\Passport\HasApiTokens;
use Illuminate\Contracts\Auth\MustVerifyEmail;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable, HasRoles, HasApiTokens;

    protected $guarded = ['id'];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'role' => UserRoles::class,
    ];
    protected $guard = 'web';

    public function roleEnum(): UserRoles
    {
        return $this->role;
    }

    public function hasRole(UserRoles $role): bool
    {
        return $this->roleEnum() === $role;
    }

    public function isAdmin(): bool
    {
        return $this->role === \App\Models\Enums\UserRoles::Admin;
    }

    public function isManager(): bool
    {
        return $this->role === \App\Models\Enums\UserRoles::Manager;
    }

    public function isUser(): bool
    {
        return $this->role === \App\Models\Enums\UserRoles::User;
    }


    public function products()
    {
        return $this->hasMany(Product::class);
    }
    
    public function scopeFrontendUsers($query)
    {
        return $query->where('role', 'user'); // assuming role is 'user' for customers
    }
}
