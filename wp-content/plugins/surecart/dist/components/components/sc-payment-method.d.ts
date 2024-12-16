import type { Components, JSX } from "../types/components";

interface ScPaymentMethod extends Components.ScPaymentMethod, HTMLElement {}
export const ScPaymentMethod: {
    prototype: ScPaymentMethod;
    new (): ScPaymentMethod;
};
/**
 * Used to define this component and all nested components recursively.
 */
export const defineCustomElement: () => void;
