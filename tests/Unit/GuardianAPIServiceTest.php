<?php

namespace Tests\Unit;

use App\Services\News\GuardianService;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class GuardianAPIServiceTest extends TestCase
{
    protected string $url;
    protected string $responseBodyPath = 'tests/Fixtures/Helpers/guardian-api-response.php';

    protected function setUp(): void
    {
        parent::setUp();

        $baseUrl = config('news_sources.guardian.url');
        $apiKey = config('news_sources.guardian.api_key');
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

    public function test_fetch_articles_from_guardian_api()
    {
        $body = include base_path($this->responseBodyPath);
        $this->mockHttpResponse($body);

        $guardianService = new GuardianService();
        $articles = $guardianService->fetchArticles();

        $this->assertIsArray($articles);
        $this->assertCount(2, $articles);
        $this->assertEquals("World news", $articles[0]['category_name']);
    }

    public function test_empty_response_from_guardianapi()
    {
        $this->mockHttpResponse(['articles' => []]);

        $guardianService = new GuardianService();
        $articles = $guardianService->fetchArticles();

        $this->assertIsArray($articles);
        $this->assertEmpty($articles);
    }
}
