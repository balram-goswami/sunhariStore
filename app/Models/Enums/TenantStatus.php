<?php 

namespace  App\Models\Enums;

enum TenantStatus: int
{
    case Verified = 1;
    case NotVerified = 0;

    public function label(): string
    {
        return match ($this) {
            self::Verified => 'Verified',
            self::NotVerified => 'Not Verified',
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::Verified => 'success',
            self::NotVerified => 'danger',
        };
    }
}