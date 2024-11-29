<?php

namespace Tests\Unit;

use Illuminate\Support\Facades\Http;
use App\Services\News\NewYorkTimesService;
use Tests\TestCase;

class NewYorkTimesAPIServiceTest extends TestCase
{
    public function test_fetch_articles_from_newyorktime()
    {   
        $body = include base_path('tests/Fixtures/Helpers/new-yoke-times-response.php');
        $baseUrl = config('news_sources.new_york_times.url');
        $apiKey = config('news_sources.new_york_times.api_key');
        $url = "{$baseUrl}?api-key={$apiKey}";

        $body = include base_path('tests/Fixtures/Helpers/new-yoke-times-response.php');
      
        Http::fake([
            $url => Http::response($body, 200),
        ]);

        $newsService = new NewYorkTimesService();
        $articles = $newsService->fetchArticles();
        $this->assertIsArray($articles);
        $this->assertCount(1, $articles);
        $this->assertEquals("Cease-Fire Deal Leaves Beleaguered Palestinians in Gaza Feeling Forgotten", $articles[0]['title']);
    }

    /**
     * Test empty response from NewsAPI
     */
    public function test_empty_response_from_newyorktime()
    {   
        $baseUrl = config('news_sources.new_york_times.url');
        $apiKey = config('news_sources.new_york_times.api_key');
        $url = "{$baseUrl}?api-key={$apiKey}";

        Http::fake([
            $url => Http::response(['results' => []], 200)
        ]);

        $newsService = new NewYorkTimesService();
        $articles = $newsService->fetchArticles();

        $this->assertIsArray($articles);
        $this->assertEmpty($articles);
    }
}
