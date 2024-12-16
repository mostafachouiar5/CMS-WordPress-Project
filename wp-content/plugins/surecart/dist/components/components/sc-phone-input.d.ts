import type { Components, JSX } from "../types/components";

interface ScPhoneInput extends Components.ScPhoneInput, HTMLElement {}
export const ScPhoneInput: {
    prototype: ScPhoneInput;
    new (): ScPhoneInput;
};
/**
 * Used to define this component and all nested components recursively.
 */
export const defineCustomElement: () => void;
