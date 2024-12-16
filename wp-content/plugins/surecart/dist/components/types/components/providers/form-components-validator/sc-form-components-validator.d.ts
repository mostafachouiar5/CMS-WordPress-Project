import { TaxProtocol } from '../../../types';
export declare class ScFormComponentsValidator {
    el: HTMLScFormComponentsValidatorElement;
    private removeCheckoutListener;
    private removePaymentRequiresShippingListener;
    /** Disable validation? */
    disabled: boolean;
    /** The tax protocol */
    taxProtocol: TaxProtocol;
    /** Is there an address field? */
    hasAddress: boolean;
    /** Is there a tax id field? */
    hasTaxIDField: boolean;
    /** Is there a bumps field? */
    hasBumpsField: boolean;
    /** Is there a tax line? */
    hasTaxLine: boolean;
    /** Is there a bump line? */
    hasBumpLine: boolean;
    /** Is there shipping choices */
    hasShippingChoices: boolean;
    /** Is there a shipping amount */
    hasShippingAmount: boolean;
    /** Is there an invoice details */
    hasInvoiceDetails: boolean;
    /** Is there an invoice memo */
    hasInvoiceMemo: boolean;
    /** Is there a trial line item */
    hasTrialLineItem: boolean;
    handleOrderChange(): void;
    handleHasAddressChange(): void;
    componentWillLoad(): void;
    disconnectedCallback(): void;
    handleShippingAddressRequired(): void;
    addAddressField(): void;
    addTaxIDField(): void;
    addBumps(): void;
    addTaxLine(): void;
    addShippingChoices(): void;
    addShippingAmount(): void;
    addInvoiceDetails(): void;
    addInvoiceMemo(): void;
    addTrialLineItem(): void;
    render(): any;
}
