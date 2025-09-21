<?php 

namespace App\Models\Enums;

enum ProductStatus: int
{
    case Draft = 1;
    case Publish = 2;
    case Obsolete = 3;

    public function label(): string
    {
        return match ($this) {
            self::Publish => 'Publish',
            self::Draft => 'Draft',
            self::Obsolete => 'Obsolete',
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::Publish => 'success',
            self::Draft => 'danger',
            self::Obsolete => 'warning',
        };
    }
}
