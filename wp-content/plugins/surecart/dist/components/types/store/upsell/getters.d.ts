/**
 * Is it busy
 */
export declare const isBusy: () => boolean;
/**
 * Get the exit url.
 */
export declare const getExitUrl: () => any;
/**
 * Get the discounted amount.
 */
export declare const getDiscountedAmount: (amount: any) => any;
/**
 * Get the scratch amount.
 */
export declare const getScratchAmount: (amount: any) => any;
/**
 * Get upsell remaining time.
 */
export declare const getUpsellRemainingTime: (timeFormat?: string) => number;
/**
 * Format time unit - add a zero if unit is less than 10.
 */
export declare const formatTimeUnit: (unit: any) => string;
/**
 * Get formatted remaining time.
 */
export declare const getFormattedRemainingTime: () => string;
/**
 * Is upsell expired.
 */
export declare const isUpsellExpired: () => boolean;
