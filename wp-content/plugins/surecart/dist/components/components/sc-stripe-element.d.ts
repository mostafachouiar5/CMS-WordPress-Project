import type { Components, JSX } from "../types/components";

interface ScStripeElement extends Components.ScStripeElement, HTMLElement {}
export const ScStripeElement: {
    prototype: ScStripeElement;
    new (): ScStripeElement;
};
/**
 * Used to define this component and all nested components recursively.
 */
export const defineCustomElement: () => void;
