import { PaymentIntent, PaymentMethodType } from "../../../types";
export declare class ScMollieAddMethod {
    country: string;
    successUrl: string;
    processorId: string;
    currency: string;
    liveMode: boolean;
    customerId: string;
    methods: PaymentMethodType[];
    loading: boolean;
    error: string;
    selectedMethodId: string;
    paymentIntent: PaymentIntent;
    componentWillLoad(): void;
    createPaymentIntent(): Promise<void>;
    fetchMethods(): Promise<void>;
    handleSubmit(): void;
    renderLoading(): any;
    render(): any;
}
