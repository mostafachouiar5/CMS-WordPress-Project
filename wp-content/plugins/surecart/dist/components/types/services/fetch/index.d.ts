import { Price, Product } from '../../types';
export declare const getPricesAndProducts: ({ ids, archived }: {
    ids: Array<string>;
    archived: boolean;
}) => Promise<{
    prices: any;
    products: any;
}>;
export declare const normalizePrices: (prices: Array<Price>) => {
    prices: any;
    products: any;
};
/**
 * Get prices
 */
export declare const getProducts: ({ query }: {
    query: Object;
}) => Promise<Product[]>;
