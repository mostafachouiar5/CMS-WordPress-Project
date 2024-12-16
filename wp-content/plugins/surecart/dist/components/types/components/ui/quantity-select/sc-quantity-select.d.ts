import { EventEmitter } from '../../../stencil-public-runtime';
/**
 * @part base - The elements base wrapper.
 * @part input - The input control.
 * @part minus - The minus control.
 * @part minus-icon - The minus icon.
 * @part plus - The plus control.
 * @part plus-icon - The plus icon.
 */
export declare class ScQuantitySelect {
    el: HTMLScQuantitySelectElement;
    private input;
    clickEl?: HTMLElement;
    disabled: boolean;
    max: number;
    min: number;
    quantity: number;
    size: 'small' | 'medium' | 'large';
    /** Inputs focus */
    hasFocus: boolean;
    scChange: EventEmitter<number>;
    /** Emitted when the control receives input. */
    scInput: EventEmitter<number>;
    /** Emitted when the control gains focus. */
    scFocus: EventEmitter<void>;
    /** Emitted when the control loses focus. */
    scBlur: EventEmitter<void>;
    decrease(): void;
    increase(): void;
    handleBlur(): void;
    handleFocus(): void;
    handleChange(): void;
    handleInput(): void;
    render(): any;
}
