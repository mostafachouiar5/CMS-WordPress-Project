/**
 * Clear the current checkout.
 */
export declare const clearCheckout: () => void;
/**
 * Lock the checkout (disables input and submission)
 * Pass a lock name to prevent conflicts and allow multiple locks.
 */
export declare const lockCheckout: (lockName: any) => any[];
/**
 * Unlock the checkout.
 * Pass an optional lock name to only unlock a specific lock
 */
export declare const unLockCheckout: (lockName?: string) => string[];
/**
 * Update the checkout line item
 */
export declare const updateCheckoutLineItem: ({ id, data }: {
    id: any;
    data: any;
}) => Promise<void>;
/**
 * Remove the checkout line item.
 */
export declare const removeCheckoutLineItem: (id: any) => Promise<void>;
/**
 * Add the checkout line item.
 */
export declare const addCheckoutLineItem: (data: any) => Promise<void>;
/**
 * Track order bump offers.
 */
export declare const trackOrderBump: (bumpId: string) => void;
