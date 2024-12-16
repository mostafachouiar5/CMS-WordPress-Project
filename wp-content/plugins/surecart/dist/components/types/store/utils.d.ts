import { Product } from '../types';
export declare const getSerializedState: () => any;
/**
 * Is this variant option sold out.
 */
export declare const isProductVariantOptionSoldOut: (optionNumber: any, option: any, variantValues: any, product: Product) => boolean;
/**
 * Is this variant option missing/unavailable?
 */
export declare const isProductVariantOptionMissing: (optionNumber: number, option: string, variantValues: any, product: Product) => boolean;
