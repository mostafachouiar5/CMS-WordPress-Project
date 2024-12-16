import { Purchase } from '../../../../types';
export declare class ScDownloadsList {
    el: HTMLScDownloadsListElement;
    /** Customer id to fetch subscriptions */
    query: any;
    allLink: string;
    heading: string;
    isCustomer: boolean;
    requestNonce: string;
    purchases: Array<Purchase>;
    /** Loading state */
    loading: boolean;
    busy: boolean;
    /** Error message */
    error: string;
    pagination: {
        total: number;
        total_pages: number;
    };
    componentWillLoad(): void;
    initialFetch(): Promise<void>;
    fetchItems(): Promise<void>;
    /** Get all subscriptions */
    getItems(): Promise<Purchase[]>;
    nextPage(): void;
    prevPage(): void;
    render(): any;
}
