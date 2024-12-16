import { EventEmitter } from '../../../../stencil-public-runtime';
import { Checkout } from '../../../../types';
export declare class ScCustomerEmail {
    private input;
    private removeCheckoutListener;
    /** A message for tracking confirmation. */
    trackingConfirmationMessage: string;
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
    /**
     * This will be true when the control is in an invalid state. Validity is determined by props such as `type`,
     * `required`, `minlength`, `maxlength`, and `pattern` using the browser's constraint validation API.
     */
    invalid: boolean;
    /** The input's autofocus attribute. */
    autofocus: boolean;
    /** Inputs focus */
    hasFocus: boolean;
    /** Emitted when the control's value changes. */
    scChange: EventEmitter<void>;
    /** Emitted when the clear button is activated. */
    scClear: EventEmitter<void>;
    /** Emitted when the control receives input. */
    scInput: EventEmitter<void>;
    /** Emitted when the control gains focus. */
    scFocus: EventEmitter<void>;
    /** Emitted when the control loses focus. */
    scBlur: EventEmitter<void>;
    /** Update the order state. */
    scUpdateOrderState: EventEmitter<Checkout>;
    /** Update the abandoned cart. */
    scUpdateAbandonedCart: EventEmitter<boolean>;
    /** Prompt for login. */
    scLoginPrompt: EventEmitter<void>;
    handleChange(): Promise<void>;
    reportValidity(): Promise<boolean>;
    /** Sync customer email with session if it's updated by other means */
    handleSessionChange(): void;
    /** Listen to checkout. */
    componentWillLoad(): void;
    /** Remove listener. */
    disconnectedCallback(): void;
    renderOptIn(): any;
    render(): any;
}
