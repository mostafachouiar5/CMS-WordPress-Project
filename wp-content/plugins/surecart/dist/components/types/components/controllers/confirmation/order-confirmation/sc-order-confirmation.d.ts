import { Checkout } from '../../../../types';
export declare class ScOrderConfirmation {
    order: Checkout;
    /** Loading */
    loading: boolean;
    /** Error */
    error: string;
    componentWillLoad(): void;
    /** Get session id from url. */
    getSessionId(): void | import("@wordpress/url/build-types/get-query-arg").QueryArgParsed;
    /** Update a session */
    getSession(): Promise<void>;
    state(): {
        processor: string;
        loading: boolean;
        orderId: void | import("@wordpress/url/build-types/get-query-arg").QueryArgParsed;
        order: Checkout;
        customer: string | import("../../../../types").Customer;
        manualPaymentTitle: string;
        manualPaymentInstructions: string;
    };
    renderOnHold(): any;
    renderManualInstructions(): any;
    render(): any;
}
