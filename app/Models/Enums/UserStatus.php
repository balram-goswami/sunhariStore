<?php 

namespace  App\Models\Enums;

enum UserStatus: int
{
    case Active = 1;
    case Pending = 2;
    case Blocked = 3;

    public function label(): string
    {
        return match ($this) {
            self::Active => 'Active',
            self::Pending => 'Pending',
            self::Blocked => 'Blocked',
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::Active => 'success',
            self::Pending => 'info',
            self::Blocked => 'danger',
        };
    }
}