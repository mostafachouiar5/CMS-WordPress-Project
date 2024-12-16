import type { Components, JSX } from "../types/components";

interface ScStripeAddMethod extends Components.ScStripeAddMethod, HTMLElement {}
export const ScStripeAddMethod: {
    prototype: ScStripeAddMethod;
    new (): ScStripeAddMethod;
};
/**
 * Used to define this component and all nested components recursively.
 */
export const defineCustomElement: () => void;
