<?php

namespace App\Services\News;

interface NewsSourceInterface
{
    public function fetchArticles(): array;
    public function getSourceCode(): string;
}
