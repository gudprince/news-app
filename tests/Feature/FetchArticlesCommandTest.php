<?php

namespace Tests\Feature;

use App\Models\Article;
use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class FetchArticlesCommandTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test the command fetches and stores articles from multiple sources
     */
    public function test_fetch_articles_command_stores_articles_from_multiple_sources()
    {
        // Fake responses from Guardian API
        $body = include base_path('tests/Fixtures/Helpers/guardian-api-response.php');
        $baseUrl = config('news_sources.guardian.url');
        $apiKey = config('news_sources.guardian.api_key');

        $url = "{$baseUrl}?api-key={$apiKey}";
      
        Http::fake([
            $url => Http::response($body, 200),
        ]);

        // Fake responses from News API
        $body = include base_path('tests/Fixtures/Helpers/news-api-response.php');

        $baseUrl = config('news_sources.news_api.url');
        $apiKey = config('news_sources.news_api.api_key');

        $url = "{$baseUrl}/top-headlines?language=en&apiKey={$apiKey}";
      
        Http::fake([
            $baseUrl.'/*' => Http::response($body, 200),
        ]);

        //Fake New York Times API
        $body = include base_path('tests/Fixtures/Helpers/new-yoke-times-response.php');
        $baseUrl = config('news_sources.new_york_times.url');
        $apiKey = config('news_sources.new_york_times.api_key');
        $url = "{$baseUrl}?api-key={$apiKey}";

        $body = include base_path('tests/Fixtures/Helpers/new-yoke-times-response.php');
      
        Http::fake([
            $url => Http::response($body, 200),
        ]);



        // Run the command
        $this->artisan('articles:fetch')
            ->expectsOutput('Articles fetched and stored successfully.')
            ->assertExitCode(0);

        // Check that the articles are stored in the database
        $this->assertDatabaseHas('articles', ['title' => 'Middle East crisis live: Hezbollah says its hands are still ‘on the trigger’ amid uneasy ceasefire']);
        $this->assertDatabaseHas('articles', ['title' => 'Cease-Fire Deal Leaves Beleaguered Palestinians in Gaza Feeling Forgotten']);

        // Check that categories are created
        $this->assertDatabaseHas('categories', ['name' => 'Technology']);
        $this->assertDatabaseHas('categories', ['name' => 'World news']);
    }
}
