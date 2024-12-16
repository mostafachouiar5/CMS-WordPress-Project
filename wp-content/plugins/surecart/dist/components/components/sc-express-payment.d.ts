import type { Components, JSX } from "../types/components";

interface ScExpressPayment extends Components.ScExpressPayment, HTMLElement {}
export const ScExpressPayment: {
    prototype: ScExpressPayment;
    new (): ScExpressPayment;
};
/**
 * Used to define this component and all nested components recursively.
 */
export const defineCustomElement: () => void;
