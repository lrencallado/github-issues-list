<?php

namespace App\Services;

use Exception;
use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Facades\Http;

class GithubService
{
    /**
     * Retrieves a list of GitHub issues with the specified state.
     *
     * @param string $state The state of the issues to retrieve (e.g., 'open', 'closed', 'all'). Defaults to 'open'.
     * @return array The list of issues matching the specified state.
     *
     * @throws \Illuminate\Http\Client\RequestException If the HTTP request fails.
     */
    public function listIssues(string $state = 'open')
    {
        $response = Http::github()->get('/issues', [
            'state' => $state
        ]);

        if ($response->failed()) {
            throw new RequestException($response);
        }

        return $response->json();
    }

    /**
     * Retrieves a specific issue from a GitHub repository.
     *
     * @param string $owner The owner of the repository.
     * @param string $repo The name of the repository.
     * @param int $issueNumber The number of the issue to retrieve.
     * @return array The issue data as an associative array.
     *
     * @throws \Illuminate\Http\Client\RequestException If the HTTP request fails.
     */
    public function getIssue(string $owner, string $repo, int $issueNumber)
    {
        $response = Http::github()->get("/repos/{$owner}/{$repo}/issues/{$issueNumber}");

        if ($response->failed()) {
            throw new RequestException($response);
        }

        return $response->json();
    }
}
