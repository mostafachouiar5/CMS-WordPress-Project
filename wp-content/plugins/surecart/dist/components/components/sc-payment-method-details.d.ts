import type { Components, JSX } from "../types/components";

interface ScPaymentMethodDetails extends Components.ScPaymentMethodDetails, HTMLElement {}
export const ScPaymentMethodDetails: {
    prototype: ScPaymentMethodDetails;
    new (): ScPaymentMethodDetails;
};
/**
 * Used to define this component and all nested components recursively.
 */
export const defineCustomElement: () => void;
