import { ProcessorName } from '../../../../types';
export declare class ScExpressPayment {
    processor: ProcessorName;
    dividerText: string;
    debug: boolean;
    hasPaymentOptions: boolean;
    onPaymentRequestLoaded(): void;
    renderStripePaymentRequest(): any;
    render(): any;
}
