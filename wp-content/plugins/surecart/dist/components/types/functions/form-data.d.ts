interface FormDataEvent extends Event {
    readonly formData: FormData;
}
interface FormDataEventInit extends EventInit {
    formData: FormData;
}
declare var FormDataEvent: {
    prototype: FormDataEvent;
    new (type: string, eventInitDict?: FormDataEventInit): FormDataEvent;
};
export interface FormSubmitControllerOptions {
    /** A function that returns the form containing the form control. */
    form: (input: unknown) => HTMLFormElement | null;
    /** A function that returns the form control's name, which will be submitted with the form data. */
    name: (input: unknown) => string;
    /** A function that returns the form control's current value. */
    value: (input: unknown) => unknown | unknown[];
    /** A function that returns the form control's current disabled state. If disabled, the value won't be submitted. */
    disabled: (input: unknown) => boolean;
}
export declare class FormSubmitController {
    form: HTMLFormElement | null;
    input: any;
    options: FormSubmitControllerOptions;
    constructor(input: any, options?: Partial<FormSubmitControllerOptions>);
    closestElement(selector: any, el: any): any;
    addFormData(): void;
    removeFormData(): void;
    handleFormData(event: FormDataEvent): void;
}
export declare const parseFormData: (data: any) => {
    metadata?: any;
    tax_identifier?: {
        number: any;
        number_type: any;
    };
    billing_address?: {
        state?: any;
        postal_code?: any;
        line_2?: any;
        line_1?: any;
        country?: any;
        city?: any;
    };
    shipping_address?: {
        state?: any;
        postal_code?: any;
        line_2?: any;
        line_1?: any;
        country?: any;
        city?: any;
    };
    password?: any;
    phone?: any;
    last_name?: any;
    first_name?: any;
    email?: any;
    name?: any;
};
export declare const reportChildrenValidity: (element: HTMLElement) => Promise<boolean>;
export {};
