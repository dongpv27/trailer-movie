<?php

namespace App\Services;

use App\Models\Movie;
use App\Models\Category;
use App\Models\Post;
use Spatie\Sitemap\Tags\Url;
use Spatie\Sitemap\Sitemap;

class SitemapService
{
    public function generate(): string
    {
        $sitemap = Sitemap::create();

        // Static pages
        $sitemap->add(Url::create('/')
            ->setChangeFrequency(Url::CHANGE_FREQUENCY_DAILY)
            ->setPriority(1.0));

        $sitemap->add(Url::create('/trailer-hot')
            ->setChangeFrequency(Url::CHANGE_FREQUENCY_DAILY)
            ->setPriority(0.9));

        $sitemap->add(Url::create('/trailer-sap-chieu')
            ->setChangeFrequency(Url::CHANGE_FREQUENCY_DAILY)
            ->setPriority(0.9));

        $sitemap->add(Url::create('/trailer-dang-chieu')
            ->setChangeFrequency(Url::CHANGE_FREQUENCY_DAILY)
            ->setPriority(0.9));

        $sitemap->add(Url::create('/top-phim')
            ->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY)
            ->setPriority(0.8));

        $sitemap->add(Url::create('/tin-dien-anh')
            ->setChangeFrequency(Url::CHANGE_FREQUENCY_DAILY)
            ->setPriority(0.7));

        // Movies
        Movie::published()
            ->chunk(1000, function ($movies) use ($sitemap) {
                foreach ($movies as $movie) {
                    $sitemap->add(Url::create($movie->url)
                        ->setLastModificationDate($movie->updated_at)
                        ->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY)
                        ->setPriority(0.8));
                }
            });

        // Categories
        Category::chunk(1000, function ($categories) use ($sitemap) {
            foreach ($categories as $category) {
                $sitemap->add(Url::create($category->url)
                    ->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY)
                    ->setPriority(0.6));
            }
        });

        // Posts
        Post::published()
            ->chunk(1000, function ($posts) use ($sitemap) {
                foreach ($posts as $post) {
                    $sitemap->add(Url::create($post->url)
                        ->setLastModificationDate($post->updated_at)
                        ->setChangeFrequency(Url::CHANGE_FREQUENCY_MONTHLY)
                        ->setPriority(0.7));
                }
            });

        return $sitemap->render();
    }

    public function writeToFile(string $path): void
    {
        Sitemap::create()
            ->add(Url::create('/')->setPriority(1.0))
            ->add(Url::create('/trailer-hot')->setPriority(0.9))
            ->add(Url::create('/trailer-sap-chieu')->setPriority(0.9))
            ->add(Url::create('/trailer-dang-chieu')->setPriority(0.9))
            ->add(Url::create('/top-phim')->setPriority(0.8))
            ->add(Url::create('/tin-dien-anh')->setPriority(0.7))
            ->writeToFile($path);

        // Append dynamic content
        $sitemap = Sitemap::read($path);

        Movie::published()->each(function ($movie) use ($sitemap) {
            $sitemap->add(Url::create($movie->url)
                ->setLastModificationDate($movie->updated_at)
                ->setPriority(0.8));
        });

        Category::all()->each(function ($category) use ($sitemap) {
            $sitemap->add(Url::create($category->url)
                ->setPriority(0.6));
        });

        Post::published()->each(function ($post) use ($sitemap) {
            $sitemap->add(Url::create($post->url)
                ->setLastModificationDate($post->updated_at)
                ->setPriority(0.7));
        });

        $sitemap->writeToFile($path);
    }

    public function pingGoogle(): bool
    {
        $url = urlencode(config('app.url') . '/sitemap.xml');
        $pingUrl = "https://www.google.com/ping?sitemap={$url}";

        $response = @file_get_contents($pingUrl);

        return $response !== false;
    }
}
