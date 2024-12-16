import { Checkout } from '../../types';
/** The base url for this service. */
export declare const baseUrl = "surecart/v1/checkouts/";
/** Items to always expand. */
export declare const expand: string[];
/** Default data we send with every request. */
export declare const withDefaultData: (data?: {
    metadata?: any;
}) => {
    metadata: any;
    email: string;
    live_mode: boolean;
    group_key: string;
    abandoned_checkout_enabled: boolean;
    billing_matches_shipping: boolean;
};
/** Default query we send with every request. */
export declare const withDefaultQuery: (query?: {}) => {
    type: string;
    product_id: string;
    form_id: string | number;
};
/** Get the checkout id  */
export declare const findInitialCheckoutId: () => import("@wordpress/url/build-types/get-query-arg").QueryArgParsed;
/** Parse the path with expansions. */
export declare const parsePath: (id: any, endpoint?: string) => string;
/** Fethc a checkout by id */
export declare const fetchCheckout: ({ id, query }: {
    id: any;
    query?: {};
}) => Promise<Checkout>;
/** Create or update the checkout. */
export declare const createOrUpdateCheckout: ({ id, data, query }: {
    id?: any;
    data?: {};
    query?: {};
}) => Promise<unknown>;
/** Create the checkout */
export declare const createCheckout: ({ data, query }: {
    data?: {};
    query?: {};
}) => Promise<unknown>;
/** Update the checkout. */
export declare const updateCheckout: ({ id, data, query }: {
    id: any;
    data?: {};
    query?: {};
}) => Promise<unknown>;
/** Finalize a checkout */
export declare const finalizeCheckout: ({ id, data, query, processor }: {
    id: string;
    data?: any;
    query?: any;
    processor: {
        id: string;
        manual: boolean;
    };
}) => Promise<Checkout>;
/**
 * Add a line item.
 */
export declare const addLineItem: ({ checkout, data, live_mode }: {
    checkout: any;
    data: any;
    live_mode?: boolean;
}) => Promise<Checkout>;
/**
 * Remove a line item.
 */
export declare const removeLineItem: ({ checkoutId, itemId }: {
    checkoutId: any;
    itemId: any;
}) => Promise<Checkout>;
/**
 * Update a line item.
 */
export declare const updateLineItem: ({ id, data }: {
    id: any;
    data: any;
}) => Promise<Checkout>;
