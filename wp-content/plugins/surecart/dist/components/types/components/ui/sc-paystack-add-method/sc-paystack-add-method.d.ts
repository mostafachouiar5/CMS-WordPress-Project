import { PaymentIntent } from '../../../types';
export declare class ScPaystackAddMethod {
    liveMode: boolean;
    customerId: string;
    successUrl: string;
    currency: string;
    loading: boolean;
    loaded: boolean;
    error: string;
    paymentIntent: PaymentIntent;
    handlePaymentIntentCreate(): Promise<void>;
    createPaymentIntent(): Promise<void>;
    render(): any;
}
