import { EventEmitter } from '../../../../stencil-public-runtime';
import { LineItem, LineItemData, Price } from '../../../../types';
export declare class ScCustomOrderPriceInput {
    /** Id of the price. */
    priceId: string;
    /** Stores the price */
    price: Price;
    /** Is this loading */
    loading: boolean;
    /** Is this busy */
    busy: boolean;
    /** Label for the field. */
    label: string;
    /** Input placeholder. */
    placeholder: string;
    /** Is this required? */
    required: boolean;
    /** Help text. */
    help: string;
    /** Show the currency code? */
    showCode: boolean;
    /** Label for the choice. */
    lineItems: LineItem[];
    /** Internal fetching state. */
    fetching: boolean;
    /** Holds the line item for this component. */
    lineItem: LineItem;
    /** Toggle line item event */
    scUpdateLineItem: EventEmitter<LineItemData>;
    handleBlur(e: any): void;
    /** Store current line item in state. */
    handleLineItemsChange(): void;
    componentDidLoad(): void;
    /** Fetch prices and products */
    fetchPrice(): Promise<void>;
    renderEmpty(): any;
    render(): any;
}
