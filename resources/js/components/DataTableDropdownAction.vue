<script setup lang="ts">
import { Button } from '@/components/ui/button';
import {
    DropdownMenu,
    DropdownMenuContent,
    DropdownMenuItem,
    DropdownMenuLabel,
    DropdownMenuSeparator,
    DropdownMenuTrigger,
} from '@/components/ui/dropdown-menu';
import { MoreHorizontal } from 'lucide-vue-next';

defineProps<{
    id: number;
    viewRoute?: string;
}>();

defineEmits<{
    (e: 'expand'): void;
}>();

function copy(id: number) {
    navigator.clipboard.writeText(id.toString());
}
</script>

<template>
    <DropdownMenu>
        <DropdownMenuTrigger as-child>
            <Button variant="ghost" class="h-8 w-8 p-0">
                <span class="sr-only">Open menu</span>
                <MoreHorizontal class="h-4 w-4" />
            </Button>
        </DropdownMenuTrigger>
        <DropdownMenuContent align="end">
            <DropdownMenuLabel>Actions</DropdownMenuLabel>
            <DropdownMenuItem @click="copy(id)"> Copy ID </DropdownMenuItem>
            <DropdownMenuSeparator />
            <DropdownMenuItem v-if="viewRoute"><a :href="viewRoute">View details</a></DropdownMenuItem>
        </DropdownMenuContent>
    </DropdownMenu>
</template>
