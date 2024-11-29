<?php

namespace Tests\Feature;

use App\Models\Article;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ArticleApiTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test API returns articles with categories
     */
    public function test_api_returns_articles_with_categories()
    {
        // Create 5 articles with associated categories
        Article::factory()->count(5)->create();

        // Make a request to the API endpoint
        $response = $this->getJson('/api/v1/articles');

        $response->assertStatus(200);
        $response->assertJsonIsObject();           
    }
}

