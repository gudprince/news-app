<?php

namespace Tests\Unit;

use Illuminate\Support\Facades\Http;
use App\Services\News\NewYorkTimesService;
use Tests\TestCase;

class NewYorkTimesAPIServiceTest extends TestCase
{
    protected string $url;
    protected string $responseBodyPath = 'tests/Fixtures/Helpers/new-yoke-times-response.php';

    protected function setUp(): void
    {
        parent::setUp();

        $baseUrl = config('news_sources.new_york_times.url');
        $apiKey = config('news_sources.new_york_times.api_key');
        $this->url = "{$baseUrl}?api-key={$apiKey}";
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

    public function test_fetch_articles_from_newyorktime()
    {
        $body = include base_path($this->responseBodyPath);
        $this->mockHttpResponse($body);

        $newsService = new NewYorkTimesService();
        $articles = $newsService->fetchArticles();

        $this->assertIsArray($articles);
        $this->assertCount(1, $articles);
        $this->assertEquals("Cease-Fire Deal Leaves Beleaguered Palestinians in Gaza Feeling Forgotten", $articles[0]['title']);
    }

    public function test_empty_response_from_newyorktime()
    {
        $this->mockHttpResponse(['results' => []]);

        $newsService = new NewYorkTimesService();
        $articles = $newsService->fetchArticles();

        $this->assertIsArray($articles);
        $this->assertEmpty($articles);
    }
}
