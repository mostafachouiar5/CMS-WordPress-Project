import { Charge } from '../../../../types';
export declare class ScChargesList {
    el: HTMLScChargesListElement;
    /** Query to fetch charges */
    query: {
        page: number;
        per_page: number;
    };
    heading: string;
    showPagination: boolean;
    allLink: string;
    charges: Array<Charge>;
    /** Loading state */
    loading: boolean;
    loaded: boolean;
    /** Error message */
    error: string;
    pagination: {
        total: number;
        total_pages: number;
    };
    /** Only fetch if visible */
    componentWillLoad(): void;
    /** Get items */
    getItems(): Promise<void>;
    renderRefundStatus(charge: Charge): any;
    renderEmpty(): any;
    renderLoading(): any;
    renderContent(): any;
    nextPage(): void;
    prevPage(): void;
    render(): any;
}
