<?php

declare(strict_types=1);

namespace App\Services;

use Illuminate\Support\Facades\Http;

/**
 * Repository provider implementation for GitLab.
 */

class GitlabRepositoryProvider implements RepositoryProviderInterface
{
    /**
     * Search GitLab repositories based on a query string.
     *
     * @param string $query The search query.
     * @return array The list of repositories.
     */

    public function searchRepositories(string $query): array
    {
        // Send a GET request to GitLab's projects API

        $response = Http::get('https://gitlab.com/api/v4/projects', [
            'search' => $query,
            'per_page' => 5,
            'order_by' => 'id',
            'sort' => 'asc',
        ]);

        // Return an empty array if the request failed
        if ($response->failed()) {
            return [];
        }

        // Get the response data
        $items = $response->json() ?? [];

        $repositories = array_map(function ($item) {
            return [
                'repository' => $item['name'],
                'full_repository_name' => $item['path_with_namespace'],
                'description' => $item['description'],
                'creator' => $item['namespace']['path'],
            ];
            
        }, $items);

        return $repositories;
    }
}
