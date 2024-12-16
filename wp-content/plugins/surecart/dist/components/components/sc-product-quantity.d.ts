import type { Components, JSX } from "../types/components";

interface ScProductQuantity extends Components.ScProductQuantity, HTMLElement {}
export const ScProductQuantity: {
    prototype: ScProductQuantity;
    new (): ScProductQuantity;
};
/**
 * Used to define this component and all nested components recursively.
 */
export const defineCustomElement: () => void;
