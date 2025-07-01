<script setup lang="ts" generic="T">
import type { ColumnDef, ColumnFiltersState, ExpandedState, SortingState, VisibilityState } from '@tanstack/vue-table';
import {
    FlexRender,
    getCoreRowModel,
    getExpandedRowModel,
    getFilteredRowModel,
    getPaginationRowModel,
    getSortedRowModel,
    useVueTable,
} from '@tanstack/vue-table';
import { CirclePlus, Filter, Columns3 } from 'lucide-vue-next';
import { Button } from '@/components/ui/button';
import { DropdownMenu, DropdownMenuCheckboxItem, DropdownMenuContent, DropdownMenuTrigger } from '@/components/ui/dropdown-menu';
import { Input } from '@/components/ui/input';
import { Table, TableBody, TableCell, TableHead, TableHeader, TableRow } from '@/components/ui/table';
import { valueUpdater } from '@/lib/utils';
import { ref, shallowRef } from 'vue';
import type { Filters } from '@/types/datatable';

const props = defineProps<{
    data: T[];
    columns: ColumnDef<T>[];
    filters: Filters[];
    actions?: {
        create?: {
            enable: boolean;
            route: string;
        };
    };
}>();

const data = shallowRef(props.data);
const sorting = ref<SortingState>([]);
const columnFilters = ref<ColumnFiltersState>([]);
const columnVisibility = ref<VisibilityState>({});
const rowSelection = ref({});
const expanded = ref<ExpandedState>({});
const globalFilter = ref<string | number>('')

const table = useVueTable({
    data,
    columns: props.columns,
    getCoreRowModel: getCoreRowModel(),
    getPaginationRowModel: getPaginationRowModel(),
    getSortedRowModel: getSortedRowModel(),
    getFilteredRowModel: getFilteredRowModel(),
    getExpandedRowModel: getExpandedRowModel(),
    onSortingChange: (updaterOrValue) => valueUpdater(updaterOrValue, sorting),
    onColumnFiltersChange: (updaterOrValue) => valueUpdater(updaterOrValue, columnFilters),
    onColumnVisibilityChange: (updaterOrValue) => valueUpdater(updaterOrValue, columnVisibility),
    onRowSelectionChange: (updaterOrValue) => valueUpdater(updaterOrValue, rowSelection),
    onExpandedChange: (updaterOrValue) => valueUpdater(updaterOrValue, expanded),
    onGlobalFilterChange: (updaterOrValue) => valueUpdater(updaterOrValue, globalFilter),
    state: {
        get sorting() {
            return sorting.value;
        },
        get columnFilters() {
            return columnFilters.value;
        },
        get columnVisibility() {
            return columnVisibility.value;
        },
        get rowSelection() {
            return rowSelection.value;
        },
        get expanded() {
            return expanded.value;
        },
        get globalFilter() {
            return globalFilter.value;
        },
    },
    // initialState: {
    //     columnFilters: props.filters
    //         .filter(f => f.value !== undefined)
    //         .map(f => ({ id: f.key, value: f.value })),
    // },
});
</script>

<template>
    <div class="w-full">
        <div class="flex items-center gap-2 py-4">
            <Input
                class="max-w-52"
                placeholder="Search...."
                :model-value="globalFilter"
                @update:model-value="(val) => {
                    globalFilter = val
                    table.setGlobalFilter(val)
                }"
            />
            <Button as-child v-if="props.actions?.create?.enable">
                <a :href="props.actions.create.route" class="flex items-center">
                    <CirclePlus class="h-4 w-4" />
                    Create
                </a>
            </Button>
            <div class="flex items-center space-x-2 ml-auto">
                <DropdownMenu v-if="props.filters?.length">
                    <DropdownMenuTrigger as-child>
                        <Button variant="outline" class="relative">
                            <Filter class="h-4 w-4" />
                        </Button>
                    </DropdownMenuTrigger>
                    <DropdownMenuContent class="w-56 py-4 px-4">
                        <DropdownMenuLabel>
                            Filters
                        </DropdownMenuLabel>
                        <DropdownMenuSeparator />
                        <DropdownMenuCheckboxItem
                            v-for="filter in props.filters"
                            :key="filter.key"
                            v-model:model-value="filter.checked"
                            @update:model-value="(val) => table.getColumn(filter.key)?.setFilterValue(val ? filter.value : undefined)"
                        >
                            {{ filter.label }}
                        </DropdownMenuCheckboxItem>
                    </DropdownMenuContent>
                </DropdownMenu>
                <DropdownMenu>
                    <DropdownMenuTrigger as-child>
                        <Button variant="outline" class="ml-auto"><Columns3 class="h-4 w-4" /> </Button>
                    </DropdownMenuTrigger>
                    <DropdownMenuContent class="w-56 py-4 px-4">
                        <DropdownMenuLabel>Columns</DropdownMenuLabel>
                        <DropdownMenuSeparator />
                        <DropdownMenuCheckboxItem
                            v-for="column in table.getAllColumns().filter((column) => column.getCanHide())"
                            :key="column.id"
                            class="capitalize"
                            :model-value="column.getIsVisible()"
                            @update:model-value="
                                (value) => {
                                    column.toggleVisibility(!!value);
                                }
                            "
                        >
                            {{ column.id }}
                        </DropdownMenuCheckboxItem>
                    </DropdownMenuContent>
                </DropdownMenu>
            </div>
        </div>
        <div class="rounded-md border">
            <Table>
                <TableHeader>
                    <TableRow v-for="headerGroup in table.getHeaderGroups()" :key="headerGroup.id">
                        <TableHead v-for="header in headerGroup.headers" :key="header.id">
                            <FlexRender v-if="!header.isPlaceholder" :render="header.column.columnDef.header" :props="header.getContext()" />
                        </TableHead>
                    </TableRow>
                </TableHeader>
                <TableBody>
                    <template v-if="table.getRowModel().rows?.length">
                        <template v-for="row in table.getRowModel().rows" :key="row.id">
                            <TableRow :data-state="row.getIsSelected() && 'selected'">
                                <TableCell v-for="cell in row.getVisibleCells()" :key="cell.id">
                                    <FlexRender :render="cell.column.columnDef.cell" :props="cell.getContext()" />
                                </TableCell>
                            </TableRow>
                            <TableRow v-if="row.getIsExpanded()">
                                <TableCell :colspan="row.getAllCells().length">
                                    {{ JSON.stringify(row.original) }}
                                </TableCell>
                            </TableRow>
                        </template>
                    </template>

                    <TableRow v-else>
                        <TableCell :colspan="columns.length" class="h-24 text-center"> No results. </TableCell>
                    </TableRow>
                </TableBody>
            </Table>
        </div>

        <div class="flex items-center justify-end space-x-2 py-4">
            <div class="text-muted-foreground flex-1 text-sm">
                {{ table.getFilteredSelectedRowModel().rows.length }} of {{ table.getFilteredRowModel().rows.length }} row(s) selected.
            </div>
            <div class="space-x-2">
                <Button variant="outline" size="sm" :disabled="!table.getCanPreviousPage()" @click="table.previousPage()"> Previous </Button>
                <Button variant="outline" size="sm" :disabled="!table.getCanNextPage()" @click="table.nextPage()"> Next </Button>
            </div>
        </div>
    </div>
</template>
