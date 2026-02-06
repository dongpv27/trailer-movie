<?php

namespace App\Console\Commands;

use App\Services\SitemapService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class GenerateSitemap extends Command
{
    protected $signature = 'sitemap:generate {--ping : Ping Google after generation}';

    protected $description = 'Generate sitemap.xml for the website';

    public function __construct(
        private SitemapService $sitemapService
    ) {
        parent::__construct();
    }

    public function handle(): int
    {
        $this->info('Generating sitemap...');

        try {
            $path = public_path('sitemap.xml');

            $this->sitemapService->writeToFile($path);

            $this->info("Sitemap generated successfully at: {$path}");

            if ($this->option('ping')) {
                $this->info('Pinging Google...');
                $result = $this->sitemapService->pingGoogle();

                if ($result) {
                    $this->info('Google pinged successfully!');
                } else {
                    $this->warn('Failed to ping Google.');
                }
            }

            return self::SUCCESS;
        } catch (\Exception $e) {
            $this->error("Failed to generate sitemap: {$e->getMessage()}");
            Log::error('Sitemap generation failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return self::FAILURE;
        }
    }
}
