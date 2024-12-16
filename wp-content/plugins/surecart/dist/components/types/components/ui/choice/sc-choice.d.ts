import { EventEmitter } from '../../../stencil-public-runtime';
export declare class ScChoice {
    el: HTMLScChoiceElement;
    private formController;
    private input;
    private inputId;
    private labelId;
    /** Does the choice have focus */
    hasFocus: boolean;
    /** Does the choice have focus */
    isStacked: boolean;
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
    /** Show the label */
    showLabel: boolean;
    /** Show the price */
    showPrice: boolean;
    /** Show the radio/checkbox control */
    showControl: boolean;
    hasDefaultSlot: boolean;
    hasPrice: boolean;
    hasPer: boolean;
    hasDescription: boolean;
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
    getAllChoices(): HTMLScChoiceElement[];
    getSiblingChoices(): HTMLScChoiceElement[];
    handleKeyDown(event: KeyboardEvent): void;
    handleMouseDown(event: MouseEvent): void;
    componentDidLoad(): void;
    disconnectedCallback(): void;
    handleResize(): void;
    handleSlotChange(): void;
    handleClickEvent(): void;
    render(): any;
}
