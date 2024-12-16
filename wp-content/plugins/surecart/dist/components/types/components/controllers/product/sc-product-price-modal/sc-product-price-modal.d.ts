import { ScNoticeStore } from '../../../../types';
export declare class ScProductPriceModal {
    el: HTMLScProductBuyButtonElement;
    private priceInput;
    /** The button text */
    buttonText: string;
    /** Whether to add to cart */
    addToCart: boolean;
    /** The product id */
    productId: string;
    error: ScNoticeStore;
    submit(): Promise<void>;
    componentWillLoad(): void;
    render(): any;
}
