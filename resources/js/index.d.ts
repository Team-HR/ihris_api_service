export interface MfoFunction {
    id: number;
    semester: 1 | 2;
    year: string;
}

export interface Department {
    id: number;
    parent_id: number;
    name: string;
    alias: string;
    parent?: Department;
    children?: Department;
}

export interface CoreFunction {
    id: number;
    mfo_period_id: number;
    parent_id?: number | null;
    department_id: number;
    title: string;
    order: string;
    created_at?: string;
    updated_at?: string;
    deleted_at?: string | null;
    parent?: CoreFunction;
    children?: CoreFunction[];
    success_indicators?: SuccessIndicator[];
}

export interface SuccessIndicator {
    id: number;
    core_function_id: number;
    indicator: string;
    core_function?: CoreFunction;
    users?: User[];
}

export interface User {
    success_indicators?: SuccessIndicator[];
}
