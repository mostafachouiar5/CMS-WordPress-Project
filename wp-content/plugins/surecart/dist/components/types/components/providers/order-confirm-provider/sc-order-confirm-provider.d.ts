import { EventEmitter } from '../../../stencil-public-runtime';
import { Checkout, ManualPaymentMethod } from '../../../types';
/**
 * This component listens to the order status
 * and confirms the order when payment is successful.
 */
export declare class ScOrderConfirmProvider {
    private continueButton;
    /** The order confirm provider element */
    el: HTMLScOrderConfirmProviderElement;
    /** Whether to show success modal */
    showSuccessModal: boolean;
    /** Whether to show success modal */
    manualPaymentMethod: ManualPaymentMethod;
    /** Checkout status to listen and do payment related stuff. */
    checkoutStatus: string;
    /** Success url. */
    successUrl: string;
    /** The order is paid event. */
    scOrderPaid: EventEmitter<Checkout>;
    scSetState: EventEmitter<string>;
    /**
     * Watch for paid checkout machine state.
     * This is triggered by Stripe, Paypal or Paystack when payment succeeds.
     */
    handleConfirmOrderEvent(): void;
    /** Confirm the order. */
    confirmOrder(): Promise<void>;
    getSuccessUrl(): string;
    handleSuccessModal(): void;
    render(): any;
}
