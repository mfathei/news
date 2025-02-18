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
        ]);
    }
}
