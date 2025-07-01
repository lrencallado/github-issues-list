<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/vue3';
import { Card, CardHeader, CardDescription, CardContent } from '@/components/ui/card';
import { Issue } from '@/types/issues';

const props = defineProps<{
    issue: Issue;
}>();

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Issues',
        href: '/issues',
    },
    {
        title: 'View',
        href: '',
    },
];
</script>

<template>
    <Head title="View" />
    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="px-4 py-6">
            <Card>
                <CardHeader>
                    <h1 class="text-lg font-semibold">Issue Number: {{ props.issue.issue_number }}</h1>
                    <!-- <CardDescription>Details of the selected issue.</CardDescription> -->
                </CardHeader>
                <CardContent>
                    <div class="space-y-4">
                        <p><strong>Title:</strong></p>
                        <CardDescription>{{ props.issue.title }}</CardDescription>
                        <p><strong>Body:</strong></p>
                        <CardDescription>{{ props.issue.body }}</CardDescription>
                        <!-- <p><strong>Name:</strong> {{ enrollment.name }}</p>
                        <p><strong>Email:</strong> {{ enrollment.email }}</p>
                        <p><strong>Status:</strong> {{ enrollment.status }}</p>
                        <p><strong>School Year Format:</strong> {{ enrollment.school_year_format }}</p>
                        <p><strong>Created At:</strong> {{ enrollment.created_at }}</p> -->
                    </div>
                </CardContent>
            </Card>
        </div>
    </AppLayout>
</template>
