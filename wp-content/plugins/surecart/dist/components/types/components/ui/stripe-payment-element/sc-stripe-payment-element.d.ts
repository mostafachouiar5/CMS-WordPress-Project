import { EventEmitter } from '../../../stencil-public-runtime';
import { FormStateSetter, PaymentInfoAddedParams } from '../../../types';
export declare class ScStripePaymentElement {
    /** This element */
    el: HTMLScStripePaymentElementElement;
    /** Holds the element container. */
    private container;
    /** holds the stripe element. */
    private element;
    private unlistenToFormState;
    private unlistenToCheckout;
    /** The error. */
    error: string;
    /** Are we confirming the order? */
    confirming: boolean;
    /** Are we loaded? */
    loaded: boolean;
    /** The order/invoice was paid for. */
    scPaid: EventEmitter<void>;
    /** Set the state */
    scSetState: EventEmitter<FormStateSetter>;
    /** Payment information was added */
    scPaymentInfoAdded: EventEmitter<PaymentInfoAddedParams>;
    styles: CSSStyleDeclaration;
    componentWillLoad(): Promise<void>;
    handleStylesChange(): Promise<void>;
    fetchStyles(): Promise<void>;
    /**
     * We wait for our property value to resolve (styles have been loaded)
     * This prevents the element appearance api being set before the styles are loaded.
     */
    getComputedStyles(): Promise<unknown>;
    /** Maybe load the stripe element on load. */
    componentDidLoad(): Promise<void>;
    disconnectedCallback(): void;
    getElementsConfig(): {
        mode: string;
        amount: number;
        currency: string;
        setupFutureUsage: string;
        appearance: {
            variables: {
                colorPrimary: string;
                colorText: string;
                borderRadius: string;
                colorBackground: string;
                fontSizeBase: string;
                colorLogo: string;
                colorLogoTab: string;
                colorLogoTabSelected: string;
                colorTextPlaceholder: string;
            };
            rules: {
                '.Input': {
                    border: string;
                };
            };
        };
    };
    /** Update the payment element mode, amount and currency when it changes. */
    createOrUpdateElements(): void;
    /** Update the default attributes of the element when they cahnge. */
    handleUpdateElement(): void;
    submit(): Promise<void>;
    /**
     * Watch order status and maybe confirm the order.
     */
    maybeConfirmOrder(): Promise<void>;
    confirm(type: any, args?: {}): Promise<void>;
    render(): any;
}
