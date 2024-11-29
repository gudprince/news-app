<?php

namespace Tests\Unit;

use App\Services\News\NewsAPIService;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class NewsAPIServiceTest extends TestCase
{
    /**
     * Test fetching articles from NewsAPI
     */
    public function test_fetch_articles_from_newsapi()
    {   
        $body = include base_path('tests/Fixtures/Helpers/news-api-response.php');

        $baseUrl = config('news_sources.news_api.url');
        $apiKey = config('news_sources.news_api.api_key');

        $url = "{$baseUrl}/top-headlines?language=en&apiKey={$apiKey}";
      
        Http::fake([
            $baseUrl.'/*' => Http::response($body, 200),
        ]);

        $newsService = new NewsAPIService();
        $articles = $newsService->fetchArticles();
        $this->assertIsArray($articles);
        $this->assertCount(4, $articles);
        $this->assertEquals("Banco BPM says UniCredit's 'unusual' $10.5 billion takeover offer does not reflect its profitability - CNBC", $articles[0]['title']);
    }

    /**
     * Test empty response from NewsAPI
     */
    public function test_empty_response_from_newsapi()
    {   
        $baseUrl = config('news_sources.news_api.url');
        Http::fake([
            $baseUrl.'/*' => Http::response(['articles' => []], 200)
        ]);

        $newsService = new NewsAPIService();
        $articles = $newsService->fetchArticles();

        $this->assertIsArray($articles);
        $this->assertEmpty($articles);
    }
}
