import { Subscription } from '../../../../types';
export declare class ScSubscriptionsList {
    el: HTMLScSubscriptionsListElement;
    /** Customer id to fetch subscriptions */
    query: {
        page: number;
        per_page: number;
    };
    allLink: string;
    heading: string;
    isCustomer: boolean;
    cancelBehavior: 'period_end' | 'immediate';
    subscriptions: Array<Subscription>;
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
    fetchSubscriptions(): Promise<void>;
    /** Get all subscriptions */
    getSubscriptions(): Promise<Subscription[]>;
    nextPage(): void;
    prevPage(): void;
    renderEmpty(): any;
    renderLoading(): any;
    getSubscriptionLink(subscription: Subscription): string;
    renderList(): any[];
    renderContent(): any;
    render(): any;
}
