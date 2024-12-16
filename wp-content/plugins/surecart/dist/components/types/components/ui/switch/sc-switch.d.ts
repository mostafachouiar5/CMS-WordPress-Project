import { EventEmitter } from '../../../stencil-public-runtime';
export declare class ScSwitch {
    el: HTMLScSwitchElement;
    private formController;
    private input;
    private switchId;
    private labelId;
    /** Does it have a description? */
    hasDescription: boolean;
    private hasFocus;
    /** The switch's name attribute. */
    name: string;
    /** The switch's value attribute. */
    value: string;
    /** Disables the switch. */
    disabled: boolean;
    /** Makes the switch a required field. */
    required: boolean;
    /** Draws the switch in a checked state. */
    checked: boolean;
    /** This will be true when the control is in an invalid state. Validity is determined by the `required` prop. */
    invalid: boolean;
    reversed: boolean;
    /** This will be true as a workaround in the block editor to focus on the content. */
    edit: boolean;
    /** Emitted when the control loses focus. */
    scBlur: EventEmitter<void>;
    /** Emitted when the control's checked state changes. */
    scChange: EventEmitter<void>;
    /** Emitted when the control gains focus. */
    scFocus: EventEmitter<void>;
    /** Checks for validity and shows the browser's validation message if the control is invalid. */
    reportValidity(): Promise<boolean>;
    handleClick(): void;
    handleBlur(): void;
    handleFocus(): void;
    handleKeyDown(event: KeyboardEvent): boolean;
    handleMouseDown(event: MouseEvent): boolean;
    handleCheckedChange(): void;
    componentDidLoad(): void;
    disconnectedCallback(): void;
    render(): any;
}
