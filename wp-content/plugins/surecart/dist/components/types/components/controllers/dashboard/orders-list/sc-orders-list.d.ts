import { Order } from '../../../../types';
export declare class ScOrdersList {
    el: HTMLScOrdersListElement;
    /** Query to fetch orders */
    query: {
        page: number;
        per_page: number;
    };
    allLink: string;
    heading: string;
    isCustomer: boolean;
    orders: Array<Order>;
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
    fetchOrders(): Promise<void>;
    /** Get all orders */
    getOrders(): Promise<Order[]>;
    nextPage(): void;
    prevPage(): void;
    renderStatusBadge(order: Order): any;
    renderLoading(): any;
    renderEmpty(): any;
    renderList(): any[];
    renderContent(): any;
    render(): any;
}
