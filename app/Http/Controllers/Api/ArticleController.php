<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\ArticleService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    public function __construct(
        private readonly ArticleService $articleService
    ) {}

    public function index(Request $request): JsonResponse
    {
        $filters = $request->only([
            'search',
            'source_id',
            'category_id',
            'date_from',
            'date_to',
        ]);

        $articles = $this->articleService->getFilteredArticles(
            filters: $filters,
            perPage: $request->input('per_page', 15)
        );

        return response()->json($articles);
    }
}
