import { Checkout, LineItemData } from '../../../../types';
export declare class ScCartForm {
    private form;
    /** The quantity */
    quantity: number;
    /** The price id to add. */
    priceId: string;
    /** The variant id to add. */
    variantId: string;
    /** Are we in test or live mode. */
    mode: 'test' | 'live';
    /** The form id to use for the cart. */
    formId: string;
    /** Is it busy */
    busy: boolean;
    error: string;
    /** Find a line item with this price. */
    getLineItem(): false | LineItemData;
    /** Add the item to cart. */
    addToCart(): Promise<void>;
    addOrUpdateLineItem(data?: any): Promise<Checkout>;
    render(): any;
}
