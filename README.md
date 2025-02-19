# Laravel News Aggregator

This is a Laravel application that aggregates news from various sources and provides a simple API to access the news articles. The application is built using Laravel 11 and PHP 8.3.

## Features

- Aggregates news from multiple sources
- Provides a simple API to access the news articles
- Supports filtering news articles by source, category, date range, and search query
- Uses full-text search to search for news articles
- Uses MySQL database for storing news articles and categories

## Installation

1. Clone the repository
2. Install dependencies using Composer
3. Copy the `.env.example` file to `.env` and update the environment variables
4. Run the database migrations
5. Run the database seeder to add news sources
6. Run the news fetch command to fetch news from the sources
7. Start the application using `php artisan serve` or your preferred method

## Usage

The application provides a simple API to access the news articles. The API endpoints are documented in the `routes/api.php` file.

To fetch news from the sources, run the `news:fetch` command. This command will fetch news from all active sources and store them in the database. The command is scheduled to run hourly using Laravel's task scheduler [take a look here](https://laravel.com/docs/11.x/scheduling#running-the-scheduler).

To search for news articles, use the `search` query parameter in the API endpoint. The search will be performed using full-text search on the news article titles and descriptions.

To filter news articles by source, category, date range, and search query, use the corresponding query parameters in the API endpoint.

## Example

To fetch all news articles from the News API source, use the following API endpoint:

```
GET /api/articles?source_id=1
```

To search for news articles containing the word "Tesla", use the following API endpoint:

```
GET /api/articles?search=Tesla
```

To filter news articles by date range, use the following API endpoint:

```
GET /api/articles?date_from=2025-01-01&date_to=2025-01-31
```

To filter news articles by category, use the following API endpoint:

```
GET /api/articles?category_id=1
```
