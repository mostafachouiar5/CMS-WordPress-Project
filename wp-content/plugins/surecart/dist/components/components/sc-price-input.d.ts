import type { Components, JSX } from "../types/components";

interface ScPriceInput extends Components.ScPriceInput, HTMLElement {}
export const ScPriceInput: {
    prototype: ScPriceInput;
    new (): ScPriceInput;
};
/**
 * Used to define this component and all nested components recursively.
 */
export const defineCustomElement: () => void;
