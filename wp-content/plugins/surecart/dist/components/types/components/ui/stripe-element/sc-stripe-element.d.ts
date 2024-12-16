import { EventEmitter } from '../../../stencil-public-runtime';
import { Checkout, FormState, FormStateSetter, PaymentInfoAddedParams, ProcessorName } from '../../../types';
export declare class ScStripeElement {
    el: HTMLElement;
    private container;
    private stripe;
    private elements;
    private element;
    /** Whether this field is disabled */
    disabled: boolean;
    /** The checkout session object for finalizing intents */
    order: Checkout;
    /** Mode for the payment */
    mode: 'live' | 'test';
    /** The input's size. */
    size: 'small' | 'medium' | 'large';
    /** The input's label. Alternatively, you can use the label slot. */
    label: string;
    /** The input's help text. Alternatively, you can use the help-text slot. */
    secureText: string;
    /** Should we show the label */
    showLabel: boolean;
    /** Inputs focus */
    hasFocus: boolean;
    /** The selected processor id */
    selectedProcessorId: ProcessorName;
    /** The form state */
    formState: FormState;
    /** The order/invoice was paid for */
    scPaid: EventEmitter<void>;
    /** Set the state */
    scSetState: EventEmitter<FormStateSetter>;
    /** Payment information was added */
    scPaymentInfoAdded: EventEmitter<PaymentInfoAddedParams>;
    error: string;
    confirming: boolean;
    componentWillLoad(): Promise<void>;
    /**
     * Watch order status and maybe confirm the order.
     */
    maybeConfirmOrder(val: FormState): Promise<void>;
    /** Confirm card payment */
    confirmCardPayment(secret: any): Promise<any>;
    /** Confirm card setup. */
    confirmCardSetup(secret: any): Promise<any>;
    componentDidLoad(): void;
    render(): any;
}
