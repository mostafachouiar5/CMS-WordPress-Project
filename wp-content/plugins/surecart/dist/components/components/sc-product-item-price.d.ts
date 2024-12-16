import type { Components, JSX } from "../types/components";

interface ScProductItemPrice extends Components.ScProductItemPrice, HTMLElement {}
export const ScProductItemPrice: {
    prototype: ScProductItemPrice;
    new (): ScProductItemPrice;
};
/**
 * Used to define this component and all nested components recursively.
 */
export const defineCustomElement: () => void;
