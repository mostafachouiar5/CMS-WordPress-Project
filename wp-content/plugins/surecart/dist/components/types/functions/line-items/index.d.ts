import { Bump, Checkout, ChoiceType, LineItemData, lineItems, Price, PriceChoice, Product, RecursivePartial } from '../../types';
export declare const getEnabledPriceChoices: (choices: Array<PriceChoice>) => Array<PriceChoice>;
export declare const convertPriceChoiceToLineItemData: (choice: PriceChoice) => LineItemData;
export declare const convertLineItemsToLineItemData: (lineItems: RecursivePartial<lineItems>) => Array<{
    price_id: string;
    quantity: number;
    variant_id?: string;
}>;
export declare const addLineItem: (lineItems: RecursivePartial<lineItems>, data: {
    price_id: string;
    quantity: number;
}) => {
    price_id: string;
    quantity: number;
    variant_id?: string;
}[];
/**
 * Calculates the initial line items for the session.
 */
export declare const calculateInitialLineItems: (choices: Array<PriceChoice>, choiceType: ChoiceType) => LineItemData[];
/**
 * Get the initial choice line items.
 */
export declare const getInitialChoiceLineItems: (choices: Array<PriceChoice>, choiceType: ChoiceType) => LineItemData[];
/**
 * Get price ids from line items
 * @param order
 * @returns
 */
export declare const getLineItemPriceIds: (line_items: RecursivePartial<lineItems>) => string[];
export declare const getLineItemBumpIds: (line_items: RecursivePartial<lineItems>) => string[];
export declare const getLineItemPrices: (line_items: RecursivePartial<lineItems>) => RecursivePartial<Price>[];
export declare const getLineItemByPriceId: (line_items: RecursivePartial<lineItems>, priceId: string) => RecursivePartial<import("../../types").LineItem>;
/**
 * Is this product in the checkout session?
 */
export declare const isProductInOrder: (product: RecursivePartial<Product>, order: Checkout) => boolean;
/**
 * Is the price in a checkout session
 */
export declare const isPriceInOrder: (price: RecursivePartial<Price>, order: Checkout) => boolean;
/**
 * Is the price in a checkout session
 */
export declare const isBumpInOrder: (bump: RecursivePartial<Bump>, order: Checkout) => boolean;
/**
 * Attempt to get the session id
 *
 * @param formId The form id.
 * @param order The order
 * @param refresh Should we refresh?
 *
 * @returns string
 */
export declare const getSessionId: (formId: any, order: any, refresh?: boolean) => any;
/** Check if the order has a subscription */
export declare const hasSubscription: (order: Checkout) => boolean;
export declare const hasTrial: (order: Checkout) => number;
/** Check if the order has a payment plan. */
export declare const hasPaymentPlan: (order: Checkout) => boolean;
