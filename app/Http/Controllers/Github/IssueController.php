<?php

namespace App\Http\Controllers\Github;

use App\Http\Controllers\Controller;
use App\Http\Resources\IssueResource;
use App\Http\Resources\ListIssuesResource;
use App\Services\GithubService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;

class IssueController extends Controller
{
    public function __construct(protected GithubService $githubService)
    {
    }

    /**
     * Retrieves and returns a list of open issues from the configured GitHub repository.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            return Inertia::render('issues/Index', [
                'issues' => ListIssuesResource::collection($this->githubService->listIssues())->resolve()
            ]);
        } catch (\Throwable $th) {
            Log::error('IssueController@index error', [
                'message' => $th->getMessage(),
            ]);
            return Inertia::render('issues/Index', [
                'errors' => ['message' => 'Unable to retrieve the list of issues from GitHub. Please try again later.']

            ]);
        }
    }

    /**
     * Display the specified GitHub issue.
     *
     * Retrieves a single issue from GitHub based on the provided issue number,
     * repository owner, and repository name from the request query parameters.
     * Renders the issue details using Inertia. If an error occurs during retrieval,
     * logs the error and redirects back to the issues index with an error message.
     *
     * @param int $issueNumber The number of the issue to display.
     * @param \Illuminate\Http\Request $request The current HTTP request instance.
     * @return \Inertia\Response|\Illuminate\Http\RedirectResponse
     */
    public function show($issueNumber, Request $request)
    {
        $owner = $request->query('repository_owner');
        $name = $request->query('repository_name');

        try {
            $resource = new IssueResource($this->githubService->getIssue($owner, $name, $issueNumber));

            return Inertia::render('issues/Show', [
                'issue' => $resource
            ]);
        } catch (\Throwable $th) {
            Log::error('IssueController@show error', [
                'message' => $th->getMessage(),
            ]);
            return redirect(route('issues.index'))->withErrors(['message' => 'Unable to retrieve the issue from GitHub. Please try again later.']);
        }
    }
}
