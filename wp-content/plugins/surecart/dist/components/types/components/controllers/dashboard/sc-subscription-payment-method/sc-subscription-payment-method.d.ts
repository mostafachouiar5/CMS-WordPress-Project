import { ManualPaymentMethod, PaymentMethod, Subscription } from '../../../../types';
export declare class ScSubscriptionPaymentMethod {
    /** The element */
    el: HTMLScSubscriptionPaymentElement;
    /** The heading */
    heading: string;
    /** The subscription */
    subscription: Subscription;
    /** The list of payment methods. */
    paymentMethods: PaymentMethod[];
    manualPaymentMethods: ManualPaymentMethod[];
    /** The error. */
    error: string;
    /** Loading state. */
    loading: boolean;
    busy: boolean;
    method: string;
    renderLoading(): any;
    renderEmpty(): any;
    currentPaymentMethodId(): string | PaymentMethod | ManualPaymentMethod;
    hasPaymentMethods(): number;
    hasMultiplePaymentMethods(): boolean;
    componentWillLoad(): void;
    /** Get all subscriptions */
    getPaymentMethods(): Promise<void>;
    fetchMethods(customerId: any): Promise<void>;
    deleteMethod(method: PaymentMethod): Promise<void>;
    updateMethod(e: any): Promise<void>;
    renderContent(): any;
    renderList(): any[];
    render(): any;
}
