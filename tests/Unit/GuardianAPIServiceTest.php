<?php

namespace Tests\Unit;

use App\Services\News\GuardianService;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class GuardianAPIServiceTest extends TestCase
{

    /**
     * Test fetching articles from NewsAPI
     */
    public function test_fetch_articles_from_guardian_api()
    {   
        $body = include base_path('tests/Fixtures/Helpers/guardian-api-response.php');
        $baseUrl = config('news_sources.guardian.url');
        $apiKey = config('news_sources.guardian.api_key');

        $url = "{$baseUrl}?api-key={$apiKey}";
      
        Http::fake([
            $url => Http::response($body, 200),
        ]);

        $guardianService = new GuardianService();
        $articles = $guardianService->fetchArticles();

        $this->assertIsArray($articles);
        $this->assertCount(2, $articles);
        $this->assertEquals("World news", $articles[0]['category_name']);
    }

    /**
     * Test empty response from NewsAPI
     */
    public function test_empty_response_from_guardianapi()
    {   
        $baseUrl = config('news_sources.guardian.url');
        $apiKey = config('news_sources.guardian.api_key');
        $url = "{$baseUrl}?api-key={$apiKey}";

        Http::fake([
            $url=> Http::response(['articles' => []], 200)
        ]);

        $newsService = new GuardianService();
        $articles = $newsService->fetchArticles();

        $this->assertIsArray($articles);
        $this->assertEmpty($articles);
    }
}
