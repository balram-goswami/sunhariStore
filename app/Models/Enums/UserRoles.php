<?php 

namespace App\Models\Enums;

enum UserRoles: int
{
    case Admin = 1;
    case Manager = 2;
    case User = 3;

    public function label(): string
    {
        return match ($this) {
            self::Admin => 'Administrator',
            self::Manager => 'Manager',
            self::User => 'User',
        };
    }
}