import { PaymentIntent } from '../../../types';
export declare class ScPaypalAddMethod {
    /** Holds the card button */
    private container;
    private paypal;
    liveMode: boolean;
    customerId: string;
    successUrl: string;
    currency: string;
    loading: boolean;
    loaded: boolean;
    error: string;
    paymentIntent: PaymentIntent;
    componentWillLoad(): void;
    handlePaymentIntentCreate(): Promise<void>;
    createPaymentIntent(): Promise<void>;
    render(): any;
}
