export declare class ScProductDonationAmountChoice {
    el: HTMLScProductDonationAmountChoiceElement;
    /** The product id for the fields. */
    productId: string;
    /** The value of the field. */
    value: number;
    /** The label for the field. */
    label: string;
    state(): {
        product: import("../../../../types").Product;
        selectedPrice: import("../../../../types").Price;
        ad_hoc_amount: number;
        custom_amount: number;
        amounts: number[];
    };
    render(): any;
}
