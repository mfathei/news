<?php

namespace App\Console\Commands;

use App\Models\Source;
use App\Services\NewsAggregatorService;
use App\Services\News\NewsAPISource;
use Illuminate\Console\Command;

class FetchNewsCommand extends Command
{
    protected $signature = 'news:fetch';
    protected $description = 'Fetch news from all active sources';

    public function handle(NewsAggregatorService $aggregator): int
    {
        $sources = Source::where('is_active', true)->get();

        foreach ($sources as $source) {
            $this->info("Fetching news from {$source->name}...");

            $newsSource = match ($source->code) {
                'newsapi' => new NewsAPISource($source->base_url, $source->api_key),
                // Add other sources here
                default => throw new \RuntimeException("Unknown source: {$source->code}"),
            };

            try {
                $aggregator->aggregateNews($newsSource);
                $this->info("Successfully fetched news from {$source->name}");
            } catch (\Exception $e) {
                $this->error("Failed to fetch news from {$source->name}: {$e->getMessage()}");
            }
        }

        return self::SUCCESS;
    }
}
