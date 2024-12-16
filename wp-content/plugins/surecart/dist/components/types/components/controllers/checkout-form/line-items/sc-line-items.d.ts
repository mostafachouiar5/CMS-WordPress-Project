import { LineItem } from '../../../../types';
/**
 * @part base - The component base
 * @part line-item - The line item
 * @part product-line-item - The product line item
 * @part line-item__image - The line item image
 * @part line-item__text - The line item text
 * @part line-item__title - The line item title
 * @part line-item__suffix - The line item suffix
 * @part line-item__price - The line item price
 * @part line-item__price-amount - The line item price amount
 * @part line-item__price-description - The line item price description
 * @part line-item__price-scratch - The line item price scratch
 * @part line-item__static-quantity - The line item static quantity
 * @part line-item__remove-icon - The line item remove icon
 * @part line-item__quantity - The line item quantity
 * @part line-item__quantity-minus - The line item quantity minus
 * @part line-item__quantity-minus-icon - The line item quantity minus icon
 * @part line-item__quantity-plus - The line item quantity plus
 * @part line-item__quantity-plus-icon - The line item quantity plus icon
 * @part line-item__quantity-input - The line item quantity input
 * @part line-item__price-description - The line item price description
 */
export declare class ScLineItems {
    /**
     * Is the line item editable?
     */
    editable: boolean;
    /**
     * Is the line item removable?
     */
    removable: boolean;
    /**
     * Is the line item editable?
     */
    isEditable(item: LineItem): boolean;
    render(): any;
}
