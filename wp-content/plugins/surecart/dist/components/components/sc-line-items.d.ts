import type { Components, JSX } from "../types/components";

interface ScLineItems extends Components.ScLineItems, HTMLElement {}
export const ScLineItems: {
    prototype: ScLineItems;
    new (): ScLineItems;
};
/**
 * Used to define this component and all nested components recursively.
 */
export const defineCustomElement: () => void;
