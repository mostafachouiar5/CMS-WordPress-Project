/**
 * @part form-control - The elements base wrapper.
 * @part label - The label.
 * @part input - The input wrapper.
 * @part help-text - Help text.
 * @part tooltip - Tooltip
 * @part tooltip-text - Tooltip text.
 */
export declare class ScFormControl {
    el: HTMLScFormControlElement;
    /** Size of the label */
    size: 'small' | 'medium' | 'large';
    /** Name for the input. Used for validation errors. */
    name: string;
    /** Show the label. */
    showLabel: boolean;
    /** Input label. */
    label: string;
    /** Input label id. */
    labelId: string;
    /** Input id. */
    inputId: string;
    /** Whether the input is required. */
    required: boolean;
    /** Help text */
    help: string;
    /** Help id */
    helpId: string;
    render(): any;
}
