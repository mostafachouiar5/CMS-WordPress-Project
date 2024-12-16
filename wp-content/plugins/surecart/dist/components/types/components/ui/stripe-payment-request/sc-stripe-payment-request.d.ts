import { EventEmitter } from '../../../stencil-public-runtime';
import { Checkout, LineItem, Prices, ResponseError } from '../../../types';
export declare class ScStripePaymentRequest {
    el: HTMLElement;
    private request;
    private stripe;
    private paymentRequest;
    private elements;
    private removeCheckoutListener;
    /** Your stripe connected account id. */
    stripeAccountId: string;
    /** Stripe publishable key */
    publishableKey: string;
    /** Country */
    country: string;
    /** Prices */
    prices: Prices;
    /** Label */
    label: string;
    /** Amount */
    amount: number;
    /** Payment request theme */
    theme: string;
    error: ResponseError | null;
    /** Is this in debug mode. */
    debug: boolean;
    /** Has this loaded */
    loaded: boolean;
    debugError: string;
    scFormSubmit: EventEmitter<any>;
    scPaid: EventEmitter<void>;
    scPayError: EventEmitter<any>;
    scSetState: EventEmitter<string>;
    scPaymentRequestLoaded: EventEmitter<boolean>;
    scUpdateOrderState: EventEmitter<any>;
    private pendingEvent;
    private confirming;
    componentWillLoad(): Promise<boolean>;
    handleOrderChange(): void;
    handleLoaded(): void;
    handleErrorChange(): void;
    handleShippingChange(ev: any): Promise<void>;
    /** Only append price name if there's more than one product price in the session. */
    getName(item: LineItem): string;
    getRequestObject(order: Checkout): {
        currency: string;
        total: {
            amount: number;
            label: string;
            pending: boolean;
        };
        displayItems: {
            label: string;
            amount: number;
        }[];
    };
    componentDidLoad(): void;
    /** Handle the payment method. */
    handlePaymentMethod(ev: any): Promise<void>;
    confirmPayment(val: Checkout, ev: any): Promise<any>;
    /** Confirm card payment. */
    confirmCardPayment(secret: any, ev: any): Promise<import("@stripe/stripe-js").PaymentIntentResult>;
    /** Confirm card setup. */
    confirmCardSetup(secret: any, ev: any): Promise<import("@stripe/stripe-js").SetupIntentResult>;
    disconnectedCallback(): void;
    render(): any;
}
