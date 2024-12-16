import { PaymentIntent } from '../../../types';
export declare class ScStripeAddMethod {
    /** Holds the element container. */
    private container;
    private elements;
    private element;
    private stripe;
    liveMode: boolean;
    customerId: string;
    successUrl: string;
    loading: boolean;
    loaded: boolean;
    error: string;
    paymentIntent: PaymentIntent;
    componentWillLoad(): void;
    handlePaymentIntentCreate(): Promise<void>;
    createPaymentIntent(): Promise<void>;
    /**
     * Handle form submission.
     */
    handleSubmit(e: any): Promise<void>;
    render(): any;
}
