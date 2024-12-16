import { PaymentMethod } from '../../../types';
export declare class ScPaymentMethod {
    paymentMethod: PaymentMethod;
    full: boolean;
    externalLink: string;
    externalLinkTooltipText: string;
    renderBankAccountType(type: any): string;
    renderExternalLink(): any;
    render(): any;
}
