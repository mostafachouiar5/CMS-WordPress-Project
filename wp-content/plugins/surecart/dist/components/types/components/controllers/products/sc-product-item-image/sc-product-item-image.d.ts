import { Product } from '../../../../types';
export declare class ScProductItemImage {
    product: Product;
    sizing: 'cover' | 'contain';
    getSrc(): string;
    render(): any;
}
