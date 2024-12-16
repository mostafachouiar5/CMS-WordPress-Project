import type { Components, JSX } from "../types/components";

interface ScProductPrice extends Components.ScProductPrice, HTMLElement {}
export const ScProductPrice: {
    prototype: ScProductPrice;
    new (): ScProductPrice;
};
/**
 * Used to define this component and all nested components recursively.
 */
export const defineCustomElement: () => void;
