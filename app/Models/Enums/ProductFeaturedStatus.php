<?php 

namespace  App\Models\Enums;

enum ProductFeaturedStatus: int
{
    case Enabled = 1;
    case Disabled = 0;

    public function label(): string
    {
        return match ($this) {
            self::Enabled => 'Enabled',
            self::Disabled => 'Disabled',
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::Enabled => 'info',
            self::Disabled => 'gray',
        };
    }
}