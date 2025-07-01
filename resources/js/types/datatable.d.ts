export interface Filters {
    key: string;
    value?: string | number;
    label: string;
    type: 'select' | 'text';
    checked?: boolean;
    options?: { label: string; value: string }[];
}
