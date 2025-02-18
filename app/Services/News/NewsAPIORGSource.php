<?php

namespace App\Services\News;

use Illuminate\Support\Facades\Http;

class NewsAPIORGSource implements NewsSourceInterface
{
    public function __construct(
        private readonly string $baseUrl,
        private readonly string $apiKey
    ) {}

    public function fetchArticles(): array
    {
        $response = Http::get($this->baseUrl, [
            'apiKey' => $this->apiKey,
            'q' => 'tesla',
            'from' => today()->subDays(7)->format('Y-m-d'),
        ]);

        return collect($response->json()['articles'] ?? [])
        ->map(function ($article) {
            return $this->mapResponse($article);
        })->all();
    }

    private function mapResponse($article)
    {
        return [
            'url' => $article['url'] ?? null,
            'title' => $article['title'] ?? null,
            'description' => $article['description'] ?? null,
            'content' => $article['content'],
            'author' => $article['author'] ?? null,
            'image_url' => $article['urlToImage'] ?? null,
            'published_at' => $article['publishedAt'],
            'external_id' => $article['url'] ?? null,
        ];
    }

    public function getSourceCode(): string
    {
        return 'newsapi-org';
    }
}
