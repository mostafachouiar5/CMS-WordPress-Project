import { Invoice } from '../../../../types';
export declare class ScInvoicesList {
    el: HTMLScInvoicesListElement;
    /** Query to fetch invoices */
    query: {
        page: number;
        per_page: number;
    };
    allLink: string;
    heading: string;
    isCustomer: boolean;
    invoices: Array<Invoice>;
    /** Loading state */
    loading: boolean;
    busy: boolean;
    /** Error message */
    error: string;
    pagination: {
        total: number;
        total_pages: number;
    };
    /** Only fetch if visible */
    componentWillLoad(): void;
    initialFetch(): Promise<void>;
    fetchInvoices(): Promise<void>;
    /** Get all invoices */
    getInvoices(): Promise<Invoice[]>;
    nextPage(): void;
    prevPage(): void;
    renderLoading(): any;
    renderEmpty(): any;
    getInvoiceRedirectUrl(invoice: Invoice): string;
    renderList(): any[];
    renderContent(): any;
    render(): any;
}
