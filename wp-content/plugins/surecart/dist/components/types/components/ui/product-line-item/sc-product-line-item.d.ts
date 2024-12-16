import { EventEmitter } from '../../../stencil-public-runtime';
import { Fee, ImageAttributes } from '../../../types';
/**
 * @part base - The component base
 * @part product-line-item - The product line item
 * @part image - The product image
 * @part text - The product text
 * @part title - The product title
 * @part suffix - The product suffix
 * @part price - The product price
 * @part price__amount - The product price amount
 * @part price__description - The product price description
 * @part price__scratch - The product price scratch
 * @part static-quantity - The product static quantity
 * @part remove-icon__base - The product remove icon
 * @part quantity - The product quantity
 * @part quantity__minus - The product quantity minus
 * @part quantity__minus-icon - The product quantity minus icon
 * @part quantity__plus - The product quantity plus
 * @part quantity__plus-icon - The product quantity plus icon
 * @part quantity__input - The product quantity input
 * @part line-item__price-description - The line item price description
 */
export declare class ScProductLineItem {
    el: HTMLScProductLineItemElement;
    /** Image attributes. */
    image: ImageAttributes;
    /** Product name */
    name: string;
    /** Price name */
    priceName?: string;
    /** Product variant label */
    variantLabel: string;
    /** Quantity */
    quantity: number;
    /** Product monetary amount */
    amount: number;
    /** Product line item fees. */
    fees: Fee[];
    /** Is the setup fee not included in the free trial? */
    setupFeeTrialEnabled: boolean;
    /** The line item scratch amount */
    scratchAmount: number;
    /** Currency for the product */
    currency: string;
    /** Recurring interval (i.e. monthly, once, etc.) */
    interval: string;
    /** Trial duration days */
    trialDurationDays: number;
    /** Is the line item removable */
    removable: boolean;
    /** Can we select the quantity */
    editable: boolean;
    /** The max allowed. */
    max: number;
    /** The SKU. */
    sku: string;
    /** The purchasable status display */
    purchasableStatusDisplay: string;
    /** Emitted when the quantity changes. */
    scUpdateQuantity: EventEmitter<number>;
    /** Emitted when the quantity changes. */
    scRemove: EventEmitter<void>;
    renderPriceAndInterval(): any;
    renderPurchasableStatus(): any;
    render(): any;
}
