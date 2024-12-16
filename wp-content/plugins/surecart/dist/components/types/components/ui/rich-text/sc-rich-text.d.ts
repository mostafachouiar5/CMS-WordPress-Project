import { EventEmitter } from '../../../stencil-public-runtime';
export declare class ScRichText {
    private inputId;
    private helpId;
    private labelId;
    /** The textarea's size. */
    size: 'small' | 'medium' | 'large';
    /** The textarea's name attribute. */
    name: string;
    /** The textarea's value attribute. */
    value: string;
    /** The textarea's label. Alternatively, you can use the label slot. */
    label: string;
    /** Should we show the label */
    showLabel: boolean;
    /** The textarea's help text. Alternatively, you can use the help-text slot. */
    help: string;
    /** The textarea's placeholder text. */
    placeholder: string;
    /** The max length. */
    maxlength: number;
    /** Disables the textarea. */
    disabled: boolean;
    /** Makes the textarea readonly. */
    readonly: boolean;
    /** Makes the textarea a required field. */
    required: boolean;
    updatedAt: any;
    hasFocus: boolean;
    scChange: EventEmitter<void>;
    scInput: EventEmitter<void>;
    scBlur: EventEmitter<void>;
    scFocus: EventEmitter<void>;
    private element;
    private editor;
    componentDidLoad(): void;
    handleFocus(): void;
    handleBlur(): void;
    isActive(type: any, opts?: {}): any;
    toggleHeading(opts: any): void;
    toggleBold(): void;
    toggleItalic(): void;
    can(property: any): any;
    run(property: any): any;
    remainingCharacters(): number;
    handleKeyDown(event: KeyboardEvent): void;
    render(): any;
}
