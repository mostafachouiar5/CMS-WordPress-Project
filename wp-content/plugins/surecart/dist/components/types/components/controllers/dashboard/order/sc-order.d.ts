import { Order, Purchase } from '../../../../types';
export declare class ScOrder {
    el: HTMLScOrdersListElement;
    orderId: string;
    customerIds: string[];
    heading: string;
    order: Order;
    purchases: Purchase[];
    /** Loading state */
    loading: boolean;
    busy: boolean;
    /** Error message */
    error: string;
    /** Only fetch if visible */
    componentDidLoad(): void;
    fetchOrder(): Promise<void>;
    fetchDownloads(): Promise<void>;
    /** Get order */
    getOrder(): Promise<void>;
    renderLoading(): any;
    renderEmpty(): any;
    renderContent(): any;
    render(): any;
}
