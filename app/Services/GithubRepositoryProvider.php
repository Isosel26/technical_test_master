<?php

declare(strict_types=1);

namespace App\Services;

use Illuminate\Support\Facades\Http;

/**
 * Repository provider implementation for GitHub.
 */

class GithubRepositoryProvider implements RepositoryProviderInterface
{
    // Send a GET request to GitHub's search API
    public function searchRepositories(string $query): array
    {
        $response = Http::get('https://api.github.com/search/repositories', [
            'q' => $query,
            'per_page' => 5,
        ]);

        // Retrieve the 'items' array from the response
        $items = $response->json()['items'] ?? [];

        // Transform the items into a standardized format
        $repositories = array_map(function ($item) {
            return [
                'repository' => $item['name'],
                'full_repository_name' => $item['full_name'],
                'description' => $item['description'],
                'creator' => $item['owner']['login'],
            ];
            
        }, $items);

        return $repositories;
    }
}
