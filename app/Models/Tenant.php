<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Tenant extends Model
{
    protected $guarded = ['id'];

    public static function boot()
    {
        parent::boot();
        static::creating(function ($tenant) {
            $tenant->verification_token = Str::random(32);
        });
    }

    public function settings()
    {
        return $this->hasOne(TenantSetting::class);
    }
    public function getDashboardUrl(): string
    {
        return \App\Filament\Resources\ProductResource::getUrl('index', [
            'tenant' => $this->id,
        ]);
    }
}
