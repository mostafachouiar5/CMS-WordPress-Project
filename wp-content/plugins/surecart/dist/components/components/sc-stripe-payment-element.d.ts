import type { Components, JSX } from "../types/components";

interface ScStripePaymentElement extends Components.ScStripePaymentElement, HTMLElement {}
export const ScStripePaymentElement: {
    prototype: ScStripePaymentElement;
    new (): ScStripePaymentElement;
};
/**
 * Used to define this component and all nested components recursively.
 */
export const defineCustomElement: () => void;
