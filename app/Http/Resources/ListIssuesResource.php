<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ListIssuesResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'issue_number' => $this['number'],
            'title' => $this['title'],
            'created_at' => $this['created_at'],
            'repository_owner' => $this['repository']['owner']['login'],
            'repository_name' => $this['repository']['name']
        ];
    }
}
