import { EventEmitter } from '../../../stencil-public-runtime';
/**
 * @part base - The elements base wrapper.
 * @part input - The html input element.
 * @part form-control - The form control wrapper.
 * @part label - The input label.
 * @part help-text - Help text that describes how to use the input.
 */
export declare class ScTextarea {
    private inputId;
    private helpId;
    private labelId;
    el: HTMLScTextareaElement;
    private formController;
    private input;
    private resizeObserver;
    private hasFocus;
    private showCharLimit;
    /** The textarea's size. */
    size: 'small' | 'medium' | 'large';
    /** The textarea's name attribute. */
    name: string;
    /** The textarea's value attribute. */
    value: string;
    /** Draws a filled textarea. */
    filled: boolean;
    /** The textarea's label. Alternatively, you can use the label slot. */
    label: string;
    /** Should we show the label */
    showLabel: boolean;
    /** The textarea's help text. Alternatively, you can use the help-text slot. */
    help: string;
    /** The textarea's placeholder text. */
    placeholder: string;
    /** The number of rows to display by default. */
    rows: number;
    /** Controls how the textarea can be resized. */
    resize: 'none' | 'vertical' | 'auto';
    /** Disables the textarea. */
    disabled: boolean;
    /** Makes the textarea readonly. */
    readonly: boolean;
    /** The minimum length of input that will be considered valid. */
    minlength: number;
    /** The maximum length of input that will be considered valid. */
    maxlength: number;
    /** Makes the textarea a required field. */
    required: boolean;
    /**
     * This will be true when the control is in an invalid state. Validity is determined by props such as `type`,
     * `required`, `minlength`, and `maxlength` using the browser's constraint validation API.
     */
    invalid: boolean;
    /** The textarea's autocapitalize attribute. */
    autocapitalize: 'off' | 'none' | 'on' | 'sentences' | 'words' | 'characters';
    /** The textarea's autocorrect attribute. */
    autocorrect: string;
    /** The textarea's autocomplete attribute. */
    autocomplete: string;
    /** The textarea's autofocus attribute. */
    autofocus: boolean;
    /**
     * The input's enterkeyhint attribute. This can be used to customize the label or icon of the Enter key on virtual
     * keyboards.
     */
    enterkeyhint: 'enter' | 'done' | 'go' | 'next' | 'previous' | 'search' | 'send';
    /** Enables spell checking on the textarea. */
    spellcheck: boolean;
    /** The textarea's inputmode attribute. */
    inputmode: 'none' | 'text' | 'decimal' | 'numeric' | 'tel' | 'search' | 'email' | 'url';
    scChange: EventEmitter<void>;
    scInput: EventEmitter<void>;
    scBlur: EventEmitter<void>;
    scFocus: EventEmitter<void>;
    handleRowsChange(): void;
    handleValueChange(): void;
    handleDisabledChange(): void;
    /** Sets focus on the input. */
    triggerFocus(options?: FocusOptions): Promise<void>;
    /** Sets focus on the textarea. */
    focus(options?: FocusOptions): void;
    /** Removes focus from the textarea. */
    blur(): void;
    /** Selects all the text in the textarea. */
    select(): void;
    /** Gets or sets the textarea's scroll position. */
    scrollPosition(position?: {
        top?: number;
        left?: number;
    }): {
        top: number;
        left: number;
    } | undefined;
    /** Sets the start and end positions of the text selection (0-based). */
    setSelectionRange(selectionStart: number, selectionEnd: number, selectionDirection?: 'forward' | 'backward' | 'none'): void;
    /** Replaces a range of text with a new string. */
    setRangeText(replacement: string, start: number, end: number, selectMode?: 'select' | 'start' | 'end' | 'preserve'): void;
    /** Checks for validity and shows the browser's validation message if the control is invalid. */
    reportValidity(): Promise<boolean>;
    /** Sets a custom validation message. If `message` is not empty, the field will be considered invalid. */
    setCustomValidity(message: string): void;
    handleBlur(): void;
    handleChange(): void;
    handleFocus(): void;
    handleInput(): void;
    componentWillLoad(): void;
    componentDidLoad(): void;
    disconnectedCallback(): void;
    setTextareaHeight(): void;
    render(): any;
}
