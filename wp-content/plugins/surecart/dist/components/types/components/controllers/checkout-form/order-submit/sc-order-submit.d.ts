import { Checkout, Processor, ProcessorName } from '../../../../types';
export declare class ScOrderSubmit {
    /** Is the order loading. */
    loading: boolean;
    /** Is the order paying. */
    paying: boolean;
    /** The button type. */
    type: 'default' | 'primary' | 'success' | 'info' | 'warning' | 'danger' | 'text' | 'link';
    /** The button's size. */
    size: 'small' | 'medium' | 'large';
    /** Show a full-width button. */
    full: boolean;
    /** Icon to show. */
    icon: string;
    /** Show the total. */
    showTotal: boolean;
    /** Keys and secrets for processors. */
    processors: Processor[];
    /** The current order. */
    order: Checkout;
    /** Currency Code */
    currencyCode: string;
    /** The selected processor. */
    processor: ProcessorName;
    /** Secure */
    secureNoticeText: string;
    /** Show the secure notice */
    secureNotice: boolean;
    cannotShipToLocation(): boolean;
    renderPayPalButton(buttons: any): any;
    render(): any;
}
