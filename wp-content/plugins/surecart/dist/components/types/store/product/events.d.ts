import { Price, Product } from "../../types";
/**
 * Product viewed event.
 */
export declare const productViewed: (product: Product, selectedPrice: Price, quantity?: number) => void;
