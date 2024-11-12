<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\SearchRepositoryRequest;
use App\Services\RepositoryProviderInterface;
use App\Services\GithubRepositoryProvider;
use App\Services\GitlabRepositoryProvider;

class RepositoryController extends Controller
{
    private array $providers;


public function __construct()
{
    $this->providers = [
        new GitlabRepositoryProvider(),
        new GithubRepositoryProvider(),
    ];
}


    public function search(SearchRepositoryRequest $request)
    {
        $query = $request->input('q');
        $repositories = [];

        foreach ($this->providers as $provider) {
            $results = $provider->searchRepositories($query);
            $repositories = array_merge($repositories, $results);
        }

        return response()->json($repositories);
    }
}