<?php

namespace App\Repositories;

use Illuminate\Pagination\LengthAwarePaginator;

interface ArticleRepositoryInterface
{
    public function getFilteredArticles(array $filters, int $perPage = 15): LengthAwarePaginator;
}
