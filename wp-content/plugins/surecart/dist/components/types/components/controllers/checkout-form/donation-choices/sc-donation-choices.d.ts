import { EventEmitter } from '../../../../stencil-public-runtime';
import { LineItem, LineItemData } from '../../../../types';
export declare class ScDonationChoices {
    el: HTMLScDonationChoicesElement;
    private input;
    /** The price id for the fields. */
    priceId: string;
    /** The default amount to load the page with. */
    defaultAmount: string;
    /** Currency code for the donation. */
    currencyCode: string;
    /** Order line items. */
    lineItems: LineItem[];
    /** Is this loading */
    loading: boolean;
    busy: boolean;
    removeInvalid: boolean;
    /** The label for the field. */
    label: string;
    /** Holds the line item for this component. */
    lineItem: LineItem;
    /** Error */
    error: string;
    showCustomAmount: boolean;
    /** Toggle line item event */
    scRemoveLineItem: EventEmitter<LineItemData>;
    /** Toggle line item event */
    scUpdateLineItem: EventEmitter<LineItemData>;
    /** Toggle line item event */
    scAddLineItem: EventEmitter<LineItemData>;
    reportValidity(): Promise<boolean>;
    handleChange(): void;
    handleCustomAmountToggle(val: any): void;
    /** Store current line item in state. */
    handleLineItemsChange(): void;
    handleLineItemChange(val: any): void;
    componentWillLoad(): void;
    selectDefaultChoice(): void;
    getChoices(): any[] | NodeListOf<HTMLScChoiceElement>;
    removeInvalidPrices(): void;
    updateCustomAmount(): void;
    render(): any;
}
