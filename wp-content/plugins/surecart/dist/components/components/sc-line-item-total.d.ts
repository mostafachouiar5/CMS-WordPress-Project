import type { Components, JSX } from "../types/components";

interface ScLineItemTotal extends Components.ScLineItemTotal, HTMLElement {}
export const ScLineItemTotal: {
    prototype: ScLineItemTotal;
    new (): ScLineItemTotal;
};
/**
 * Used to define this component and all nested components recursively.
 */
export const defineCustomElement: () => void;
