<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { Errors, type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/vue3';
import DropdownAction from '@/components/DataTableDropdownAction.vue';
import DataTableTanstack from '@/components/DataTableTanstack.vue';
import { Button } from '@/components/ui/button';
import type { ColumnDef } from '@tanstack/vue-table';
import { ArrowUpDown } from 'lucide-vue-next';
import { h } from 'vue';
import { Filters } from '@/types/datatable';
import { IssuesList } from '@/types/issues';

const props = defineProps<{
    issues: IssuesList[];
    errors: Errors;
}>();

const columns: ColumnDef<IssuesList>[] = [
    {
        accessorKey: 'issue_number',
        header: ({ column }) => {
            return h(
                Button,
                {
                    variant: 'ghost',
                    onClick: () => column.toggleSorting(column.getIsSorted() === 'asc'),
                },
                () => ['Issue Number', h(ArrowUpDown, { class: 'ml-2 h-4 w-4' })],
            );
        },
        cell: ({ row }) => h('div', { class: '' }, row.getValue('issue_number')),
    },
    {
        accessorKey: 'title',
        header: ({ column }) => {
            return h(
                Button,
                {
                    variant: 'ghost',
                    onClick: () => column.toggleSorting(column.getIsSorted() === 'asc'),
                },
                () => ['Title', h(ArrowUpDown, { class: 'ml-2 h-4 w-4' })],
            );
        },
        cell: ({ row }) => h('div', { class: '' }, row.getValue('title')),
    },
    {
        accessorKey: 'created_at',
        header: ({ column }) => {
            return h(
                Button,
                {
                    variant: 'ghost',
                    onClick: () => column.toggleSorting(column.getIsSorted() === 'asc'),
                },
                () => ['Created At', h(ArrowUpDown, { class: 'ml-2 h-4 w-4' })],
            );
        },
        cell: ({ row }) => {
            const value = row.getValue('created_at');
            if (!value) return '';
            const date = new Date(value);
            const options: Intl.DateTimeFormatOptions = {
                year: 'numeric',
                month: 'long',
                day: 'numeric',
                hour: 'numeric',
                minute: '2-digit',
                hour12: true,
            };
            const formatted = date.toLocaleString('en-US', options)
                .replace(',', '') // Remove comma after day
                .replace('AM', 'am')
                .replace('PM', 'pm');
            return h('div', { class: '' }, formatted);
        },
    },
    {
        id: 'actions',
        enableHiding: false,
        cell: ({ row }) => {
            const issue = row.original;

            return h(
                'div',
                { class: 'relative' },
                h(DropdownAction, {
                    id: issue,
                    onExpand: row.toggleExpanded,
                    viewRoute: route('issues.show', {
                        issue_number: issue.issue_number,
                        repository_owner: issue.repository_owner,
                        repository_name: issue.repository_name
                    }),
                }),
            );
        },
    },
];

const filters:Filters[] = [];

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Issues',
        href: '/issues',
    },
];
</script>

<template>
    <Head title="List of Issues" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="px-4 py-6">
            <div v-if="props.errors.message" class="text-red-600">
                {{ props.errors.message }}
            </div>
            <DataTableTanstack :data="props.issues" :columns="columns" :filters="filters"/>
        </div>
    </AppLayout>
</template>
