import type { Components, JSX } from "../types/components";

interface ScCart extends Components.ScCart, HTMLElement {}
export const ScCart: {
    prototype: ScCart;
    new (): ScCart;
};
/**
 * Used to define this component and all nested components recursively.
 */
export const defineCustomElement: () => void;
