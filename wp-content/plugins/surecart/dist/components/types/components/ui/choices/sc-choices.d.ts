/**
 * @part base - The elements base wrapper.
 * @part choices - The choices wrapper.
 * @part form-control - The form control wrapper.
 * @part label - The input label.
 * @part help-text - Help text that describes how to use the input.
 */
export declare class ScChoices {
    el: HTMLScChoicesElement;
    private inputId;
    private helpId;
    private labelId;
    /** The group label. Required for proper accessibility. Alternatively, you can use the label slot. */
    label: string;
    /** Input size */
    size: 'small' | 'medium' | 'large';
    autoWidth: boolean;
    /** Required */
    required: boolean;
    /** Should we show the label */
    showLabel: boolean;
    /** The input's help text. */
    help: string;
    /** Hides the fieldset and legend that surrounds the group. The label will still be read by screen readers. */
    hideLabel: boolean;
    /** Number of columns on desktop */
    columns: number;
    /** Validation error message. */
    errorMessage: string;
    width: number;
    triggerFocus(): Promise<void>;
    componentDidLoad(): void;
    handleRequiredChange(): void;
    handleResize(): void;
    render(): any;
}
