<?php

namespace App\Services\News;

use Illuminate\Support\Facades\Http;

class NewsAPISource implements NewsSourceInterface
{
    public function __construct(
        private readonly string $baseUrl,
        private readonly string $apiKey
    ) {
    }

    public function fetchArticles(): array
    {
        $response = Http::get($this->baseUrl, [
            'apiKey' => $this->apiKey,
            'language' => 'en',
            'includeCategoryParentUri' => true,
            'dateStart' => today()->format('Y-m-d'),
        ]);

        return collect($response->json()['articles']['results'] ?? [])
        ->map(function ($article) {
            return $this->mapResponse($article);
        })->all();
    }

    private function mapResponse($article)
    {
        return [
            'url' => $article['url'],
            'title' => $article['title'],
            'description' => null,
            'content' => $article['body'] ?? null,
            'author' => $article['authors'][0]['name'] ?? null,
            'image_url' => $article['image'] ?? null,
            'published_at' => $article['dateTimePub'],
            'external_id' => $article['uri'] ?? null,
        ];
    }

    public function getSourceCode(): string
    {
        return 'newsapi';
    }
}
