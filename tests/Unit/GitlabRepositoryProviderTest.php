<?php

declare(strict_types=1);

namespace Tests\Unit;

use Tests\TestCase;
use App\Services\GitlabRepositoryProvider;
use Illuminate\Support\Facades\Http;

/**
 * Unit tests for the GitlabRepositoryProvider.
 */
class GitlabRepositoryProviderTest extends TestCase
{
    /**
     * Test the searchRepositories method for GitLab.
     *
     * @return void
     */
    public function testSearchRepositories()
    {
        // Mock the HTTP response for GitLab API
        Http::fake([
            'https://gitlab.com/api/v4/projects*' => Http::response([
                [
                    'name' => 'repo1',
                    'path_with_namespace' => 'user/repo1',
                    'description' => 'Description repo1',
                    'namespace' => ['path' => 'user'],
                ],
            ], 200),
        ]);

        $provider = new GitlabRepositoryProvider();
        $results = $provider->searchRepositories('test');

        // Assertions to verify the results
        $this->assertCount(1, $results);
        $this->assertEquals('repo1', $results[0]['repository']);
        $this->assertEquals('user/repo1', $results[0]['full_repository_name']);
        $this->assertEquals('Description repo1', $results[0]['description']);
        $this->assertEquals('user', $results[0]['creator']);
    }
}
