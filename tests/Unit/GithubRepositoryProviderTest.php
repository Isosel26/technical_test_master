<?php

declare(strict_types=1);

namespace Tests\Unit;

use Tests\TestCase;
use App\Services\GithubRepositoryProvider;
use Illuminate\Support\Facades\Http;

/**
 * Unit tests for the GithubRepositoryProvider.
 */
class GithubRepositoryProviderTest extends TestCase
{
    /**
     * Test the searchRepositories method for GitHub.
     *
     * @return void
     */
    public function testSearchRepositories()
    {
        // Mock the HTTP response for GitHub API
        Http::fake([
            'https://api.github.com/search/repositories*' => Http::response([
                'items' => [
                    [
                        'name' => 'repo1',
                        'full_name' => 'user/repo1',
                        'description' => 'Description repo1',
                        'owner' => ['login' => 'user'],
                    ],
                ],
            ], 200),
        ]);

        $provider = new GithubRepositoryProvider();
        $results = $provider->searchRepositories('test');

        // Assertions to verify the results
        $this->assertCount(1, $results);
        $this->assertEquals('repo1', $results[0]['repository']);
        $this->assertEquals('user/repo1', $results[0]['full_repository_name']);
        $this->assertEquals('Description repo1', $results[0]['description']);
        $this->assertEquals('user', $results[0]['creator']);
    }
}
