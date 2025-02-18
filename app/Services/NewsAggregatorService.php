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
                            'description' => $article['description'] ?? null,
                            'content' => $article['content'] ?? null,
                            'author' => $article['author'] ?? null,
                            'image_url' => $article['image_url'] ?? null,
                            'published_at' => $article['published_at'],
                            'external_id' => $article['external_id'] ?? null,
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
