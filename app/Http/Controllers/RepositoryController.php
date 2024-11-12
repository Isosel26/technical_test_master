<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\SearchRepositoryRequest;
use App\Services\RepositoryProviderInterface;
use App\Services\GithubRepositoryProvider;
use App\Services\GitlabRepositoryProvider;

/**
 * Controller for handling repository search requests.
 */

class RepositoryController extends Controller
{
    /**
     * @var RepositoryProviderInterface[] List of repository providers.
     */

    private array $providers;

    /**
     * Initialize repository providers.
     */


public function __construct()
{
    $this->providers = [
        new GitlabRepositoryProvider(),// GitLab provider
        new GithubRepositoryProvider(),// GitHub provider
    ];
}

    /**
     * Handle the repository search request.
     *
     * @param SearchRepositoryRequest $request The validated request.
     * @return \Illuminate\Http\JsonResponse The JSON response with repositories.
     */
    public function search(SearchRepositoryRequest $request)
    {
        // Retrieve the search query from the request

        $query = $request->input('q');
        $repositories = [];

         // Loop through each provider to get repositories
        foreach ($this->providers as $provider) {
            $results = $provider->searchRepositories($query);
            // Merge the results into the main repositories array
            $repositories = array_merge($repositories, $results);
        }

        // Return the combined repository data as JSON
        return response()->json($repositories);
    }
}