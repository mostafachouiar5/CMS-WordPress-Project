import { EventEmitter } from '../../../stencil-public-runtime';
export declare class ScForm {
    form: HTMLElement;
    private formElement;
    /** Prevent the form from validating inputs before submitting. */
    novalidate: boolean;
    /**
     * Emitted when the form is submitted. This event will not be emitted if any form control inside of
     * it is in an invalid state, unless the form has the `novalidate` attribute. Note that there is never a need to prevent
     * this event, since it doen't send a GET or POST request like native forms. To "prevent" submission, use a conditional
     * around the XHR request you use to submit the form's data with.
     */
    scSubmit: EventEmitter<void>;
    /**
     * Backwards compat.
     */
    scFormSubmit: EventEmitter<void>;
    /**
     * Emitted when the form is submitted. This event will not be emitted if any form control inside of
     * it is in an invalid state, unless the form has the `novalidate` attribute. Note that there is never a need to prevent
     * this event, since it doen't send a GET or POST request like native forms. To "prevent" submission, use a conditional
     * around the XHR request you use to submit the form's data with.
     */
    scFormChange: EventEmitter<Object>;
    /** Serializes all form controls elements and returns a `FormData` object. */
    getFormData(): Promise<FormData>;
    getFormJson(): Promise<Record<string, unknown>>;
    handleChange(): Promise<void>;
    submit(): Promise<void>;
    /** Gets all form control elements (native and custom). */
    getFormControls(): HTMLElement[];
    validate(): Promise<boolean>;
    submitForm(): void;
    render(): any;
}
