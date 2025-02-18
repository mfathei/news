<?php

namespace App\Services;

use App\Models\Article;
use App\Models\Source;
use App\Services\News\NewsSourceInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class NewsAggregatorService
{
    public function aggregateNews(NewsSourceInterface $source): void
    {
        try {
            $articles = $source->fetchArticles();
            $sourceModel = Source::where('code', $source->getSourceCode())->firstOrFail();

            DB::transaction(function () use ($articles, $sourceModel) {
                foreach ($articles as $article) {
                    Article::updateOrCreate(
                        [
                            'url' => $article['url'],
                            'source_id' => $sourceModel->id,
                        ],
                        [
                            'title' => $article['title'],
                            'description' => null,
                            'content' => $article['body'] ?? null,
                            'author' => $article['authors'][0]['name'] ?? null,
                            'image_url' => $article['image'] ?? null,
                            'published_at' => $article['dateTimePub'],
                            'external_id' => $article['uri'] ?? null,
                        ]
                    );
                }
            });
        } catch (\Exception $e) {
            Log::error('Failed to aggregate news from ' . $source->getSourceCode(), [
                'error' => $e->getMessage(),
            ]);
            throw $e;
        }
    }
}
