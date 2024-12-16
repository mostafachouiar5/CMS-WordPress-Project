import { Checkout } from '../../../types';
export declare class ScOrderConfirmComponentsValidator {
    /** The element. */
    el: HTMLScOrderConfirmComponentsValidatorElement;
    /** The checkout */
    checkout: Checkout;
    /** Does it have manual instructions? */
    hasManualInstructions: boolean;
    handleOrderChange(): void;
    addManualPaymentInstructions(): void;
    componentWillLoad(): void;
    render(): any;
}
