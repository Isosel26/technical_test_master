<?php

declare(strict_types=1);

namespace App\Services;
/**
 * Interface for repository providers.
 * Defines a contract for searching repositories.
 */
interface RepositoryProviderInterface
{
    /**
     * Search repositories based on a query string.
     *
     * @param string $query The search query.
     * @return array The list of repositories.
     */
    public function searchRepositories(string $query): array;
}
