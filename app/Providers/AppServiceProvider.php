<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Laravel\Passport\Passport;
use Filament\Facades\Filament;
use App\Models\Tenant;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Pagination\Paginator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        Passport::loadKeysFrom(__DIR__ . '/../secrets/oauth');

        Validator::extend('max_words', function ($attribute, $value, $parameters, $validator) {
            $limit = (int) $parameters[0];
            $words = str_word_count(strip_tags($value));
            return $words <= $limit;
        }, 'The :attribute must not be more than :max_words words.');

        Paginator::useBootstrapFive();
    }
}
