<?php

namespace App\Console\Commands;

use App\Models\PageVisit;
use App\Models\TrailerPlay;
use Illuminate\Console\Command;

class CleanupAnalyticsData extends Command
{
    protected $signature = 'analytics:cleanup {--days=90 : Delete data older than this many days}';

    protected $description = 'Clean up old analytics data (page visits and trailer plays)';

    public function handle(): int
    {
        $days = (int) $this->option('days');
        $cutoffDate = now()->subDays($days)->startOfDay();

        $this->info("Deleting analytics data older than {$days} days (before {$cutoffDate->format('Y-m-d H:i:s')})...");

        // Clean up page visits
        $pageVisitsDeleted = PageVisit::where('visited_at', '<', $cutoffDate)->delete();
        $this->info("Deleted {$pageVisitsDeleted} page visits");

        // Clean up trailer plays
        $trailerPlaysDeleted = TrailerPlay::where('played_at', '<', $cutoffDate)->delete();
        $this->info("Deleted {$trailerPlaysDeleted} trailer plays");

        $this->info('Cleanup completed successfully.');

        return self::SUCCESS;
    }
}
