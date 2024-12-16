import { Price, Product, ProductGroup, Subscription } from '../../../../types';
export declare class ScSubscriptionSwitch {
    el: HTMLScSubscriptionsListElement;
    /** Customer id to fetch subscriptions */
    query: object;
    heading: string;
    productGroupId: ProductGroup;
    productId: string;
    subscription: Subscription;
    filterAbove: number;
    successUrl: string;
    /** The currently selected price. */
    selectedPrice: Price;
    /** Holds the products */
    products: Array<Product>;
    /** Holds the prices */
    prices: Array<Price>;
    /** Filter state */
    filter: 'month' | 'week' | 'year' | 'never' | 'split';
    hasFilters: {
        split: boolean;
        month: boolean;
        week: boolean;
        year: boolean;
        never: boolean;
    };
    showFilters: boolean;
    /** Loading state */
    loading: boolean;
    /** Busy state */
    busy: boolean;
    /** Error message */
    error: string;
    componentWillLoad(): void;
    handleProductsChange(): void;
    handlePricesChange(val: any, prev: any): void;
    handleSubscriptionChange(): void;
    hasMultipleFilters(): boolean;
    /** Get all subscriptions */
    getGroup(): Promise<void>;
    /** Get the product's prices. */
    getProductPrices(): Promise<void>;
    handleSubmit(e: any): Promise<void>;
    renderSwitcher(): any;
    renderLoading(): any;
    /** Is the price hidden or not */
    isHidden(price: Price): boolean;
    renderContent(): any;
    buttonText(): string;
    buttonDisabled(): boolean;
    render(): any;
}
