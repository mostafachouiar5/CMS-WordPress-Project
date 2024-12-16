export declare class ScProductDonationChoice {
    el: HTMLScProductDonationChoicesElement;
    /** The product id for the fields. */
    productId: string;
    /** The label for the field. */
    label: string;
    recurring: boolean;
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
