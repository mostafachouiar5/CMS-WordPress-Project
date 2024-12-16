import { EventEmitter } from '../../../stencil-public-runtime';
export declare class ScChoiceContainer {
    el: HTMLScChoiceContainerElement;
    private formController;
    private input;
    private inputId;
    private labelId;
    /** Does the choice have focus */
    hasFocus: boolean;
    /** The choice name attribute */
    name: string;
    /** The size. */
    size: 'small' | 'medium' | 'large';
    /** The choice value */
    value: string;
    /** The choice name attribute */
    type: 'radio' | 'checkbox';
    /** Is the choice disabled */
    disabled: boolean;
    /** Draws the choice in a checked state. */
    checked: boolean;
    /** Is this required */
    required: boolean;
    /** This will be true when the control is in an invalid state. Validity is determined by the `required` prop. */
    invalid: boolean;
    /** Show the radio/checkbox control */
    showControl: boolean;
    /** Role of radio/checkbox control */
    role: string;
    /** Emitted when the control loses focus. */
    scBlur: EventEmitter<void>;
    /** Emitted when the control's checked state changes. */
    scChange: EventEmitter<boolean>;
    /** Emitted when the control gains focus. */
    scFocus: EventEmitter<void>;
    /** Simulates a click on the choice. */
    triggerClick(): Promise<void>;
    triggerFocus(): Promise<void>;
    /** Checks for validity and shows the browser's validation message if the control is invalid. */
    reportValidity(): Promise<boolean>;
    handleCheckedChange(): void;
    handleBlur(): void;
    handleFocus(): void;
    /** Sets a custom validation message. If `message` is not empty, the field will be considered invalid. */
    setCustomValidity(message: string): Promise<void>;
    getAllChoices(): (HTMLScChoiceElement | HTMLScChoiceContainerElement)[];
    getSiblingChoices(): HTMLScChoiceElement[];
    handleKeyDown(event: KeyboardEvent): void;
    componentDidLoad(): void;
    disconnectedCallback(): void;
    handleClickEvent(): void;
    render(): any;
}
