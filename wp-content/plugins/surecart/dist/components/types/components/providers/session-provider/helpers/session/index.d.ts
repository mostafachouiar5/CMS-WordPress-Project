import { Checkout } from '../../../../../types';
export declare const getURLLineItems: () => void | import("@wordpress/url/build-types/get-query-arg").QueryArgParsed;
/** Get coupon data from url. */
export declare const getURLCoupon: () => void | import("@wordpress/url/build-types/get-query-arg").QueryArgParsed;
/** Get checkout data from url. */
export declare const getUrlData: () => {};
/**
 * Attempt to get the session id
 *
 * @param formId The form id.
 * @param order The order
 * @param refresh Should we refresh?
 *
 * @returns string
 */
export declare const getSessionId: (formId: any, order: any, modified: any) => any;
export declare const setSessionId: (formId: any, sessionId: any, modified: any, count: any) => void;
export declare const removeSessionId: (formId: any) => void;
export declare const findInput: (el: any, name: any) => HTMLElement;
export declare const populateInputs: (el: any, order: Checkout) => void;
