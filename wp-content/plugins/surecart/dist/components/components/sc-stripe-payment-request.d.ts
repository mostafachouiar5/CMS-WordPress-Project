import type { Components, JSX } from "../types/components";

interface ScStripePaymentRequest extends Components.ScStripePaymentRequest, HTMLElement {}
export const ScStripePaymentRequest: {
    prototype: ScStripePaymentRequest;
    new (): ScStripePaymentRequest;
};
/**
 * Used to define this component and all nested components recursively.
 */
export const defineCustomElement: () => void;
