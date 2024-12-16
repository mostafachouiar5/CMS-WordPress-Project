import type { Components, JSX } from "../types/components";

interface ScCheckout extends Components.ScCheckout, HTMLElement {}
export const ScCheckout: {
    prototype: ScCheckout;
    new (): ScCheckout;
};
/**
 * Used to define this component and all nested components recursively.
 */
export const defineCustomElement: () => void;
