<?php

namespace App\Services\News;

use Illuminate\Support\Facades\Http;

class GuardianSource implements NewsSourceInterface
{
    public function __construct(
        private readonly string $baseUrl,
        private readonly string $apiKey
    ) {
    }

    public function fetchArticles(): array
    {
        try {
            $response = Http::get($this->baseUrl, [
                'api-key' => $this->apiKey,
                'show-fields' => 'body,headline,thumbnail',
                'from-date' => today()->format('Y-m-d'),
            ]);

            return collect($response->json()['response']['results'] ?? [])
            ->map(function ($article) {
                return $this->mapResponse($article);
            })->all();
        } catch (\Exception $e) {
            dd($e->getMessage());
        }
    }

    private function mapResponse($article)
    {
        return [
            'url' => $article['webUrl'] ?? null,
            'title' => $article['fields']['headline'] ?? null,
            'description' => null,
            'content' => $article['fields']['body'] ?? null,
            'author' => null,
            'image_url' => $article['fields']['thumbnail'] ?? null,
            'published_at' => $article['webPublicationDate'],
            'external_id' => $article['id'] ?? null,
        ];
    }

    public function getSourceCode(): string
    {
        return 'guardianapis';
    }
}
