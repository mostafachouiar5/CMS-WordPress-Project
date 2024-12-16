import type { Components, JSX } from "../types/components";

interface ScPayment extends Components.ScPayment, HTMLElement {}
export const ScPayment: {
    prototype: ScPayment;
    new (): ScPayment;
};
/**
 * Used to define this component and all nested components recursively.
 */
export const defineCustomElement: () => void;
