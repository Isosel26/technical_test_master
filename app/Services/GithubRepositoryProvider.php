<?php

declare(strict_types=1);

namespace App\Services;

use Illuminate\Support\Facades\Http;

class GithubRepositoryProvider implements RepositoryProviderInterface
{
    public function searchRepositories(string $query): array
    {
        $response = Http::get('https://api.github.com/search/repositories', [
            'q' => $query,
            'per_page' => 5,
        ]);

        $items = $response->json()['items'] ?? [];

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
