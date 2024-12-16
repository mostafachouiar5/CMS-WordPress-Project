import { EventEmitter } from '../../../stencil-public-runtime';
export declare class ScPagination {
    page: number;
    perPage: number;
    total: number;
    totalShowing: number;
    totalPages: number;
    hasNextPage: boolean;
    hasPreviousPage: boolean;
    from: number;
    to: number;
    scPrevPage: EventEmitter<void>;
    scNextPage: EventEmitter<void>;
    componentWillLoad(): void;
    handlePaginationChange(): void;
    render(): any;
}
