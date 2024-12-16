export declare class ScPassword {
    private input;
    private confirmInput;
    /** The input's size. */
    size: 'small' | 'medium' | 'large';
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
    /** The input's placeholder text. */
    placeholder: string;
    /** Disables the input. */
    disabled: boolean;
    /** Makes the input readonly. */
    readonly: boolean;
    /** Makes the input a required field. */
    required: boolean;
    /** The input's autofocus attribute. */
    autofocus: boolean;
    /** The input's password confirmation attribute. */
    confirmation: boolean;
    /** The name for the input. */
    name: string;
    /** The input's confirmation label text. */
    confirmationLabel: string;
    /** The input's confirmation placeholder text. */
    confirmationPlaceholder: string;
    /** The input's confirmation help text. */
    confirmationHelp: string;
    /** Ensures strong password validation. */
    enableValidation: boolean;
    /** Hint Text. */
    hintText: string;
    /** Verify Text. */
    verifyText: string;
    /** Sets focus on the input. */
    triggerFocus(options?: FocusOptions): Promise<void>;
    reportValidity(): Promise<boolean>;
    /** Handle password verification. */
    handleVerification(): void;
    /** Handle password validation. */
    handleValidate(): void;
    /** Validate the password input. */
    validatePassword(): string;
    /** Verify the password confirmation. */
    verifyPassword(): void;
    handleHintTextChange(): void;
    render(): any;
}
