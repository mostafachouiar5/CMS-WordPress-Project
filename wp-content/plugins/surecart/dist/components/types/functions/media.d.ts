import { FeaturedProductMediaAttributes, Product, Variant } from '../types';
export declare const sizeImage: (url: string, size: any, options?: string) => string;
export declare const getFeaturedProductMediaAttributes: (product: Product, selectedVariant?: Variant) => FeaturedProductMediaAttributes;
