import { ScNoticeStore } from '../../../../types';
export declare class ScProductBuyButton {
    el: HTMLScProductBuyButtonElement;
    addToCart: boolean;
    productId: string;
    formId: number;
    mode: 'live' | 'test';
    checkoutLink: string;
    error: ScNoticeStore;
    handleCartClick(e: any): Promise<void>;
    componentDidLoad(): void;
    private link;
    updateProductLink(): void;
    render(): any;
}
