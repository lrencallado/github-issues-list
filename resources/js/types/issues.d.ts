export interface IssuesList {
    issue_number: number;
    title: string;
    created_at: string;
    repository_owner: string;
    repository_name: string;
}

export interface Issue {
    issue_number: string;
    title: string;
    body: string;
}
