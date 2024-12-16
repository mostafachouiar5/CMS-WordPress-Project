/**
 * Gets the current checkout for the page.
 */
export declare const currentCheckout: () => any;
/**
 * Is the checkout currently locked.
 * Pass an optional lock name to find if a
 * specific lock name is locking checkout.
 */
export declare const checkoutIsLocked: (lockName?: string) => boolean;
/**
 * Get a line item by product id.
 */
export declare const getLineItemByProductId: (productId: string) => import("src/types").LineItem;
/**
 * Is the shipping address required?
 */
export declare const fullShippingAddressRequired: () => boolean;
/**
 * Is the address required?
 */
export declare const shippingAddressRequired: () => boolean;
/**
 * Get Billing address
 */
export declare const getCompleteAddress: (type?: string) => {
    name?: string;
    city?: string;
    state?: string;
    postal_code?: string;
    country?: string;
    constructor: Function;
    toString(): string;
    toLocaleString(): string;
    valueOf(): Object;
    hasOwnProperty(v: PropertyKey): boolean;
    isPrototypeOf(v: Object): boolean;
    propertyIsEnumerable(v: PropertyKey): boolean;
    line1: string;
    line2: string;
};
