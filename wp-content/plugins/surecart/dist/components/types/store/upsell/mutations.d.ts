/**
 * Internal dependencies.
 */
import { LineItem } from "../../types";
/**
 * Update the upsell.
 */
export declare const trackOffer: () => Promise<unknown>;
/**
 * Update the upsell.
 */
export declare const preview: () => Promise<void>;
export declare const accept: () => Promise<void>;
/**
 * Decline the upsell.
 */
export declare const decline: () => Promise<void>;
/**
 * Make the request to the upsell endpoing
 */
export declare const upsellRequest: (args: any) => Promise<LineItem>;
/**
 * Handle what to do on completion.
 */
export declare const handleCompletion: (checkout: any) => string;
