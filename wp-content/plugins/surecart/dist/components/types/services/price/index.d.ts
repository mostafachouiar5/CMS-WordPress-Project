import { Price } from '../../types';
/**
 * Get prices
 */
export declare const getPrices: ({ query, currencyCode }: {
    query: Object;
    currencyCode: string;
}) => Promise<Price[]>;
