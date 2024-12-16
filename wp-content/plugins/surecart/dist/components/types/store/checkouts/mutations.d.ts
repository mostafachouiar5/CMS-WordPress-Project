import { Checkout } from "../../types";
/** Get the checkout. */
export declare const getCheckout: (formId: number | string, mode: 'live' | 'test') => any;
/** Set the checkout. */
export declare const setCheckout: (data: Checkout, formId: number | string) => void;
/** Clear the order from the store. */
export declare const clearCheckout: (formId: number | string, mode: 'live' | 'test') => void;
