<?php

namespace App\Services;

use App\Repositories\ArticleRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;

class ArticleService
{
    public function __construct(
        private readonly ArticleRepositoryInterface $articleRepository
    ) {}

    public function getFilteredArticles(array $filters, int $perPage = 15): LengthAwarePaginator
    {
        return $this->articleRepository->getFilteredArticles($filters, $perPage);
    }
}
