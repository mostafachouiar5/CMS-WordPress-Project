import { EventEmitter } from '../../../stencil-public-runtime';
/**
 * @part base - The elements base wrapper.
 * @part control - The control wrapper.
 * @part checked-icon - Checked icon.
 * @part indeterminate-icon - Indeterminate icon.
 * @part label - The label.
 */
export declare class ScCheckbox {
    el: HTMLScCheckboxElement;
    private input;
    private formController;
    private inputId;
    private labelId;
    private hasFocus;
    /** The checkbox's name attribute. */
    name: string;
    /** The checkbox's value attribute. */
    value: string;
    /** Disables the checkbox. */
    disabled: boolean;
    /** Makes this edit and not editable. */
    edit: boolean;
    /** Makes the checkbox a required field. */
    required: boolean;
    /** Draws the checkbox in a checked state. */
    checked: boolean;
    /** Draws the checkbox in an indeterminate state. */
    indeterminate: boolean;
    /** This will be true when the control is in an invalid state. Validity is determined by the `required` prop. */
    invalid: boolean;
    /** Emitted when the control loses focus. */
    scBlur: EventEmitter<void>;
    /** Emitted when the control's checked state changes. */
    scChange: EventEmitter<void>;
    /** Emitted when the control gains focus. */
    scFocus: EventEmitter<void>;
    firstUpdated(): void;
    /** Simulates a click on the checkbox. */
    triggerClick(): Promise<void>;
    /** Sets focus on the checkbox. */
    triggerFocus(options?: FocusOptions): Promise<void>;
    /** Removes focus from the checkbox. */
    triggerBlur(): Promise<void>;
    /** Checks for validity and shows the browser's validation message if the control is invalid. */
    reportValidity(): Promise<boolean>;
    /** Sets a custom validation message. If `message` is not empty, the field will be considered invalid. */
    setCustomValidity(message: string): void;
    handleClick(): void;
    handleBlur(): void;
    handleFocus(): void;
    handleLabelMouseDown(): void;
    handleStateChange(): void;
    componentDidLoad(): void;
    disconnectedCallback(): void;
    render(): any;
}
