import type { Components, JSX } from "../types/components";

interface ScPrice extends Components.ScPrice, HTMLElement {}
export const ScPrice: {
    prototype: ScPrice;
    new (): ScPrice;
};
/**
 * Used to define this component and all nested components recursively.
 */
export const defineCustomElement: () => void;
