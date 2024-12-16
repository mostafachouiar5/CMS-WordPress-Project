export declare class ScProductQuantity {
    private inputId;
    private helpId;
    private labelId;
    /** Size of the control */
    size: 'small' | 'medium' | 'large';
    /** Name for the input. Used for validation errors. */
    name: string;
    /** Display server-side validation errors. */
    errors: any;
    /** Show the label. */
    showLabel: boolean;
    /** Input label. */
    label: string;
    /** Whether the input is required. */
    required: boolean;
    /** Help text */
    help: string;
    /** The product id */
    productId: string;
    render(): any;
}
