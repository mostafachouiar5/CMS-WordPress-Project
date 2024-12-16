import { Price, Variant } from '../../../../types';
export declare class ScProductPrice {
    /** The product's prices. */
    prices: Price[];
    /** The sale text */
    saleText: string;
    /** The product id */
    productId: string;
    renderRange(): any;
    renderVariantPrice(selectedVariant: Variant): any;
    renderPrice(price: Price, variantAmount?: number): any;
    render(): any;
}
