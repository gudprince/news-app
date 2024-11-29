<?php

namespace Tests\Unit;

use App\Services\News\NewsAPIService;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class NewsAPIServiceTest extends TestCase
{
    protected string $url;
    protected string $responseBodyPath = 'tests/Fixtures/Helpers/news-api-response.php';

    protected function setUp(): void
    {
        parent::setUp();

        $baseUrl = config('news_sources.news_api.url');
        $apiKey = config('news_sources.news_api.api_key');
        $this->url = "{$baseUrl}/top-headlines?language=en&apiKey={$apiKey}";
    }

    /**
     * Helper method to mock HTTP responses
     *
     * @param array|string $body
     * @param int $status
     */
    protected function mockHttpResponse($body, int $status = 200): void
    {
        Http::fake([
            $this->url => Http::response($body, $status),
        ]);
    }

    public function test_fetch_articles_from_newsapi()
    {
        $body = include base_path($this->responseBodyPath);
        $this->mockHttpResponse($body);

        $newsService = new NewsAPIService();
        $articles = $newsService->fetchArticles();

        $this->assertIsArray($articles);
        $this->assertCount(4, $articles);
        $this->assertEquals("Banco BPM says UniCredit's 'unusual' $10.5 billion takeover offer does not reflect its profitability - CNBC", $articles[0]['title']);
    }

    public function test_empty_response_from_newsapi()
    {
        $this->mockHttpResponse(['articles' => []]);

        $newsService = new NewsAPIService();
        $articles = $newsService->fetchArticles();

        $this->assertIsArray($articles);
        $this->assertEmpty($articles);
    }
}
