export declare class ScOrderPassword {
    private input;
    loggedIn: boolean;
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
    /** Does the email exist? */
    emailExists: boolean;
    /** The input's password confirmation attribute. */
    confirmation: boolean;
    /** The input's confirmation label text. */
    confirmationLabel: string;
    /** The input's confirmation placeholder text. */
    confirmationPlaceholder: string;
    /** The input's confirmation help text. */
    confirmationHelp: string;
    /** Ensures strong password validation. */
    enableValidation: boolean;
    reportValidity(): Promise<boolean>;
    render(): any;
}
