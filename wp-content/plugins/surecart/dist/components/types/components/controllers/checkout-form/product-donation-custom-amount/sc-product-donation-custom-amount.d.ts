export declare class ScProductDonationCustomAmount {
    el: HTMLScProductDonationCustomAmountElement;
    priceInput: HTMLScPriceInputElement;
    /** Selected Product Id for the donation. */
    productId: string;
    /** Custom Amount of the donation. */
    value: number;
    state(): {
        product: import("../../../../types").Product;
        selectedPrice: import("../../../../types").Price;
        ad_hoc_amount: number;
        custom_amount: number;
        amounts: number[];
    };
    updateState(data: any): void;
    render(): any;
}
