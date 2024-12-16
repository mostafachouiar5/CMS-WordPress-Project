import type { Components, JSX } from "../types/components";

interface ScLineItem extends Components.ScLineItem, HTMLElement {}
export const ScLineItem: {
    prototype: ScLineItem;
    new (): ScLineItem;
};
/**
 * Used to define this component and all nested components recursively.
 */
export const defineCustomElement: () => void;
