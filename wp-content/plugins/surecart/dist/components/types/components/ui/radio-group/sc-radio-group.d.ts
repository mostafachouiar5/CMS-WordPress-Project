import { EventEmitter } from '../../../stencil-public-runtime';
export declare class ScRadioGroup {
    /** The radio group element */
    el: HTMLScRadioGroupElement;
    /** The input for validation */
    private input;
    /** The radio group label. Required for proper accessibility. */
    label: string;
    /**
     * This will be true when the control is in an invalid state. Validity is determined by props such as `type`,
     * `required`, `minlength`, `maxlength`, and `pattern` using the browser's constraint validation API.
     */
    invalid: boolean;
    /** The selected value of the control. */
    value: string;
    /** Is one of these items required. */
    required: boolean;
    scChange: EventEmitter<string>;
    /** Checks for validity and shows the browser's validation message if the control is invalid. */
    reportValidity(): Promise<boolean>;
    handleRadioClick(event: any): void;
    componentDidLoad(): void;
    render(): any;
}
