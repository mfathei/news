<?php

namespace App\Services\News;

use Illuminate\Support\Facades\Http;

class NewsAPISource implements NewsSourceInterface
{
    public function __construct(
        private readonly string $baseUrl,
        private readonly string $apiKey
    ) {}

    public function fetchArticles(): array
    {
        $response = Http::get($this->baseUrl, [
            'apiKey' => $this->apiKey,
            'language' => 'en',
            'includeCategoryParentUri' => true,
            'dateStart' => today()->format('Y-m-d'),
        ]);

        return $response->json()['articles']['results'] ?? [];
    }

    public function getSourceCode(): string
    {
        return 'newsapi';
    }
}
