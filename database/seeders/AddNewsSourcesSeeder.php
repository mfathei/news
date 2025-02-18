<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AddNewsSourcesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \Illuminate\Support\Facades\DB::table('sources')->insert([
            [
                'name' => 'News API',
                'code' => 'newsapi',
                'api_key' => config('services.newsapi.api_key'),
                'base_url' => 'https://eventregistry.org/api/v1/article/getArticles',
                'is_active' => true,
            ],
            [
                'name' => 'News API ORG',
                'code' => 'newsapi-org',
                'api_key' => config('services.newsapi-org.api_key'),
                'base_url' => 'https://newsapi.org/v2/everything',
                'is_active' => true,
            ],
            [
                'name' => 'Guardian',
                'code' => 'guardianapis',
                'api_key' => config('services.guardianapis.api_key'),
                'base_url' => 'https://content.guardianapis.com/search',
                'is_active' => true,
            ],
        ]);
    }
}
