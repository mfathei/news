<?php

namespace App\Repositories;

use App\Models\Article;
use Illuminate\Pagination\LengthAwarePaginator;

class ArticleRepository implements ArticleRepositoryInterface
{
    public function getFilteredArticles(array $filters, int $perPage = 15): LengthAwarePaginator
    {
        return Article::with(['source', 'categories'])
            ->when($filters['search'] ?? null, function ($query, $search) {
                $query->whereFullText(['title', 'description'], $search);
            })
            ->when($filters['source_id'] ?? null, function ($query, $sourceId) {
                $query->where('source_id', $sourceId);
            })
            ->when($filters['category_id'] ?? null, function ($query, $categoryId) {
                $query->whereHas('categories', function ($query) use ($categoryId) {
                    $query->where('categories.id', $categoryId);
                });
            })
            ->when($filters['date_from'] ?? null, function ($query, $dateFrom) {
                $query->where('published_at', '>=', $dateFrom);
            })
            ->when($filters['date_to'] ?? null, function ($query, $dateTo) {
                $query->where('published_at', '<=', $dateTo);
            })
            ->orderBy('published_at', 'desc')
            ->paginate($perPage);
    }
}
