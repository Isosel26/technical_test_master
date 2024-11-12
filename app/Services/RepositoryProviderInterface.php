<?php

declare(strict_types=1);

namespace App\Services;

interface RepositoryProviderInterface
{
    public function searchRepositories(string $query): array;
}
