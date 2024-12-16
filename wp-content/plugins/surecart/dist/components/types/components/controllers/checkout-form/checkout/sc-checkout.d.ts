/// <reference types="node" />
import { EventEmitter } from '../../../../stencil-public-runtime';
import { Bump, Checkout, Customer, FormState, ManualPaymentMethod, PaymentIntents, PriceChoice, Prices, Processor, ProcessorName, Product, Products, ResponseError, TaxProtocol } from '../../../../types';
export declare class ScCheckout {
    /** Element */
    el: HTMLElement;
    /** Holds the session provider reference. */
    private sessionProvider;
    /** An array of prices to pre-fill in the form. */
    prices: Array<PriceChoice>;
    /** A product to pre-fill the form. */
    product: Product;
    /** Are we in test or live mode. */
    mode: 'test' | 'live';
    /** The checkout form id */
    formId: number;
    /** When the form was modified. */
    modified: string;
    /** Currency to use for this checkout. */
    currencyCode: string;
    /** Whether to persist the session in the browser between visits. */
    persistSession: boolean;
    /** Where to go on success */
    successUrl: string;
    /** Stores the current customer */
    customer: Customer;
    /** Alignment */
    alignment: 'center' | 'wide' | 'full';
    /** The account tax protocol */
    taxProtocol: TaxProtocol;
    /** Should we disable components validation */
    disableComponentsValidation: boolean;
    /** Processors enabled for this form. */
    processors: Processor[];
    /** Manual payment methods enabled for this form. */
    manualPaymentMethods: ManualPaymentMethod[];
    /** Can we edit line items? */
    editLineItems: boolean;
    /** Can we remove line items? */
    removeLineItems: boolean;
    /** Is abandoned checkout enabled. */
    abandonedCheckoutEnabled: boolean;
    /** Use the Stripe payment element. */
    stripePaymentElement: boolean;
    /** Stores fetched prices for use throughout component.  */
    pricesEntities: Prices;
    /** Stores fetched products for use throughout component.  */
    productsEntities: Products;
    /** Loading states for different parts of the form. */
    checkoutState: FormState;
    /** Error to display. */
    error: ResponseError | null;
    /** The currenly selected processor */
    processor: ProcessorName;
    /** The processor method. */
    method: string;
    /** Is the processor manual? */
    isManualProcessor: boolean;
    /** Holds the payment intents for the checkout. */
    paymentIntents: PaymentIntents;
    /** Is this form a duplicate form? (There's another on the page) */
    isDuplicate: boolean;
    /** Checkout has been updated. */
    scOrderUpdated: EventEmitter<Checkout>;
    /** Checkout has been finalized. */
    scOrderFinalized: EventEmitter<Checkout>;
    /** Checkout has an error. */
    scOrderError: EventEmitter<ResponseError>;
    handleOrderStateUpdate(e: {
        detail: Checkout;
    }): void;
    handleMethodChange(e: any): void;
    handleAddEntities(e: any): void;
    /**
     * Submit the form
     */
    submit({ skip_validation }?: {
        skip_validation: boolean;
    }): Promise<Checkout | NodeJS.Timeout | Error>;
    /**
     * Validate the form.
     */
    validate(): Promise<boolean>;
    componentWillLoad(): void;
    state(): {
        processor: ProcessorName;
        method: string;
        selectedProcessorId: ProcessorName;
        manualPaymentMethods: ManualPaymentMethod[];
        processor_data: import("../../../../types").ProcessorData;
        state: FormState;
        formState: any;
        paymentIntents: PaymentIntents;
        successUrl: string;
        bumps: Bump[];
        order: Checkout;
        abandonedCheckoutEnabled: boolean;
        checkout: Checkout;
        shippingEnabled: boolean;
        lineItems: import("../../../../types").LineItem[];
        editLineItems: boolean;
        removeLineItems: boolean;
        loading: boolean;
        busy: boolean;
        paying: boolean;
        empty: boolean;
        stripePaymentElement: boolean;
        stripePaymentIntent: import("../../../../types").PaymentIntent;
        error: ResponseError;
        customer: Customer;
        tax_status: "disabled" | "address_invalid" | "estimated" | "calculated";
        taxEnabled: boolean;
        customerShippingAddress: string | import("../../../../types").Address;
        shippingAddress: string | import("../../../../types").Address;
        taxStatus: "disabled" | "address_invalid" | "estimated" | "calculated";
        taxIdentifier: {
            number: string;
            number_type: string;
        };
        totalAmount: number;
        taxProtocol: TaxProtocol;
        lockedChoices: PriceChoice[];
        products: Products;
        prices: Prices;
        country: string;
        loggedIn: boolean;
        emailExists: boolean;
        formId: string | number;
        mode: "live" | "test";
        currencyCode: string;
    };
    render(): any;
}
