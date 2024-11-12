<?php

declare(strict_types=1);

namespace App\Services;

use Illuminate\Support\Facades\Http;

class GitlabRepositoryProvider implements RepositoryProviderInterface
{
    public function searchRepositories(string $query): array
    {
        $response = Http::get('https://gitlab.com/api/v4/projects', [
            'search' => $query,
            'per_page' => 5,
            'order_by' => 'id',
            'sort' => 'asc',
        ]);

        // Vérifier si la requête a réussi
        if ($response->failed()) {
            // Vous pouvez gérer les erreurs ici, par exemple en lançant une exception ou en retournant un tableau vide
            return [];
        }

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
