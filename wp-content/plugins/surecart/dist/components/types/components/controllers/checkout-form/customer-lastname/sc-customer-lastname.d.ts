import { EventEmitter } from '../../../../stencil-public-runtime';
export declare class ScCustomerLastname {
    private input;
    private removeCheckoutListener;
    /** Is the user logged in. */
    loggedIn: boolean;
    /** The input's size. */
    size: 'small' | 'medium' | 'large';
    /** The input's value attribute. */
    value: any;
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
    /**
     * This will be true when the control is in an invalid state. Validity is determined by props such as `type`,
     * `required`, `minlength`, `maxlength`, and `pattern` using the browser's constraint validation API.
     */
    invalid: boolean;
    /** The input's autofocus attribute. */
    autofocus: boolean;
    /** Inputs focus */
    hasFocus: boolean;
    /** Emitted when the control receives input. */
    scInput: EventEmitter<void>;
    /** Emitted when the control gains focus. */
    scFocus: EventEmitter<void>;
    /** Emitted when the control loses focus. */
    scBlur: EventEmitter<void>;
    /** Don't allow a blank space as an input here. */
    reportValidity(): Promise<boolean>;
    /** Silently update the checkout when the input changes. */
    handleChange(): Promise<void>;
    /** Sync customer last name with session if it's updated by other means */
    handleSessionChange(): void;
    /** Listen to checkout. */
    componentWillLoad(): void;
    /** Remove listener. */
    disconnectedCallback(): void;
    render(): any;
}
