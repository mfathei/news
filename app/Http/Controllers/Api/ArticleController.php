<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Article;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $query = Article::with(['source', 'categories'])
            ->when($request->search, function ($query, $search) {
                $query->whereFullText(['title', 'description'], $search);
            })
            ->when($request->source_id, function ($query, $sourceId) {
                $query->where('source_id', $sourceId);
            })
            ->when($request->category_id, function ($query, $categoryId) {
                $query->whereHas('categories', function ($query) use ($categoryId) {
                    $query->where('categories.id', $categoryId);
                });
            })
            ->when($request->date_from, function ($query, $dateFrom) {
                $query->where('published_at', '>=', $dateFrom);
            })
            ->when($request->date_to, function ($query, $dateTo) {
                $query->where('published_at', '<=', $dateTo);
            })
            ->orderBy('published_at', 'desc');

        $articles = $query->paginate($request->input('per_page', 15));

        return response()->json($articles);
    }
}
