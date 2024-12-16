export declare class ScOrderCouponForm {
    private couponForm;
    label: string;
    loading: boolean;
    collapsed: boolean;
    placeholder: string;
    buttonText: string;
    open: boolean;
    value: string;
    error: string;
    handleCouponApply(e: any): Promise<void>;
    render(): any;
}
