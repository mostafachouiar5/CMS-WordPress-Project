import { EventEmitter } from '../../../stencil-public-runtime';
/**
 * @part base - The elements base wrapper.
 * @part control - The control wrapper.
 * @part checked-icon - Checked icon.
 * @part label - The label.
 */
export declare class ScRadio {
    el: HTMLScRadioElement;
    private input;
    private formController;
    private inputId;
    private labelId;
    /** Does the radio have focus */
    hasFocus: boolean;
    /** The radios name attribute */
    name: string;
    /** The radios value */
    value: string;
    /** Is the radio disabled */
    disabled: boolean;
    /** Draws the radio in a checked state. */
    checked: boolean;
    /** Is this required */
    required: boolean;
    /** This will be true when the control is in an invalid state. Validity is determined by the `required` prop. */
    invalid: boolean;
    /** This will be true as a workaround in the block editor to focus on the content. */
    edit: boolean;
    /** Emitted when the control loses focus. */
    scBlur: EventEmitter<void>;
    /** Emitted when the control's checked state changes. */
    scChange: EventEmitter<void>;
    /** Emitted when the control gains focus. */
    scFocus: EventEmitter<void>;
    /** Simulates a click on the radio. */
    ceClick(): Promise<void>;
    /** Checks for validity and shows the browser's validation message if the control is invalid. */
    reportValidity(): Promise<boolean>;
    handleCheckedChange(): void;
    handleClick(): void;
    handleBlur(): void;
    handleFocus(): void;
    /** Sets a custom validation message. If `message` is not empty, the field will be considered invalid. */
    setCustomValidity(message: string): void;
    getAllRadios(): HTMLScRadioElement[];
    getSiblingRadios(): HTMLScRadioElement[];
    handleKeyDown(event: KeyboardEvent): boolean;
    handleMouseDown(event: MouseEvent): boolean;
    componentDidLoad(): void;
    disconnectedCallback(): void;
    render(): any;
}
