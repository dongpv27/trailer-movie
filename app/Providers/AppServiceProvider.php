<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // Custom str_limit helper if not available
        if (!function_exists('str_limit')) {
            function str_limit($string, $limit = 100, $end = '...')
            {
                return Str::limit($string, $limit, $end);
            }
        }
    }
}
