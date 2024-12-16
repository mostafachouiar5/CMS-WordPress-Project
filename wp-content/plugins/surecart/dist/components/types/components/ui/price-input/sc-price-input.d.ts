import { EventEmitter } from '../../../stencil-public-runtime';
/**
 * @part base - The elements base wrapper.
 * @part input - The html input element.
 * @part base - The elements base wrapper.
 * @part prefix - Used to prepend an icon or element to the input.
 * @part suffix - Used to prepend an icon or element to the input.
 * @part help-text - Help text that describes how to use the input.
 */
export declare class ScPriceInput {
    el: HTMLScPriceInputElement;
    private input;
    private formController;
    /** The input's size. */
    size: 'small' | 'medium' | 'large';
    /** The input's name attribute. */
    name: string;
    /** The input's value attribute. */
    value: string;
    /** Draws a pill-style input with rounded edges. */
    pill: boolean;
    /** The input's label. */
    label: string;
    /** Should we show the label */
    showLabel: boolean;
    /** The input's help text. */
    help: string;
    /** Adds a clear button when the input is populated. */
    clearable: boolean;
    /** The input's placeholder text. */
    placeholder: string;
    /** Disables the input. */
    disabled: boolean;
    /** Makes the input readonly. */
    readonly: boolean;
    /** The minimum length of input that will be considered valid. */
    minlength: number;
    /** The maximum length of input that will be considered valid. */
    maxlength: number;
    /** The input's maximum value. */
    max: number;
    /** The input's minimum value. */
    min: number;
    /** Makes the input a required field. */
    required: boolean;
    /**
     * This will be true when the control is in an invalid state. Validity is determined by props such as `type`,
     * `required`, `minlength`, `maxlength`, and `pattern` using the browser's constraint validation API.
     */
    invalid: boolean;
    /** The input's autofocus attribute. */
    autofocus: boolean;
    /** Inputs focus */
    hasFocus: boolean;
    /** 3 letter currency code for input */
    currencyCode: string;
    /** Show the currency code with the input */
    showCode: boolean;
    /** Emitted when the control's value changes. */
    scChange: EventEmitter<void>;
    /** Emitted when the control's value changes. */
    scInput: EventEmitter<void>;
    /** Emitted when the control gains focus. */
    scFocus: EventEmitter<void>;
    /** Emitted when the control loses focus. */
    scBlur: EventEmitter<void>;
    reportValidity(): Promise<boolean>;
    /** Sets focus on the input. */
    triggerFocus(options?: FocusOptions): Promise<void>;
    /** Sets a custom validation message. If `message` is not empty, the field will be considered invalid. */
    setCustomValidity(message: string): Promise<void>;
    /** Removes focus from the input. */
    triggerBlur(): Promise<void>;
    handleFocusChange(): void;
    handleChange(): void;
    handleInput(): void;
    updateValue(): void;
    componentDidLoad(): void;
    disconnectedCallback(): void;
    getFormattedValue(): string;
    render(): any;
}
