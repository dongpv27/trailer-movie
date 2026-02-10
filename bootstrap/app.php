<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Console\Scheduling\Schedule;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->web(append: [
            \App\Http\Middleware\TrackPageVisit::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })
    ->withSchedule(function (Schedule $schedule) {
        // Generate sitemap daily at 02:00
        $schedule->command('sitemap:generate --ping')
            ->dailyAt('02:00')
            ->description('Generate sitemap and ping Google');

        // Clean up analytics data weekly on Sunday at 03:00
        $schedule->command('analytics:cleanup --days=90')
            ->weekly()
            ->sundays()
            ->at('03:00')
            ->description('Clean up analytics data older than 90 days');
    })
    ->create();
