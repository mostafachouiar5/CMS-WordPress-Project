import { PaymentMethod, Period, Price } from '../../../../types';
export declare class ScUpcomingInvoice {
    el: HTMLScUpcomingInvoiceElement;
    heading: string;
    successUrl: string;
    subscriptionId: string;
    priceId: string;
    variantId: string;
    quantity: number;
    discount: {
        promotion_code?: string;
        coupon?: string;
    };
    payment_method: PaymentMethod;
    quantityUpdatesEnabled: boolean;
    adHocAmount: number;
    /** Loading state */
    loading: boolean;
    busy: boolean;
    /** Error message */
    error: string;
    price: Price;
    invoice: Period;
    couponError: string;
    componentWillLoad(): void;
    isFutureInvoice(): boolean;
    fetchItems(): Promise<void>;
    getPrice(): Promise<void>;
    getInvoice(): Promise<Period>;
    applyCoupon(e: any): Promise<void>;
    updateQuantity(e: any): Promise<void>;
    onSubmit(): Promise<void>;
    renderName(price: Price): string;
    renderRenewalText(): any;
    renderEmpty(): any;
    renderLoading(): any;
    renderContent(): any;
    renderSummary(): any;
    render(): any;
}
