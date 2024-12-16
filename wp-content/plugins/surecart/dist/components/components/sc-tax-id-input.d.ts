import type { Components, JSX } from "../types/components";

interface ScTaxIdInput extends Components.ScTaxIdInput, HTMLElement {}
export const ScTaxIdInput: {
    prototype: ScTaxIdInput;
    new (): ScTaxIdInput;
};
/**
 * Used to define this component and all nested components recursively.
 */
export const defineCustomElement: () => void;
