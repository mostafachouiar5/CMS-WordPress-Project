import type { Components, JSX } from "../types/components";

interface ScProductLineItem extends Components.ScProductLineItem, HTMLElement {}
export const ScProductLineItem: {
    prototype: ScProductLineItem;
    new (): ScProductLineItem;
};
/**
 * Used to define this component and all nested components recursively.
 */
export const defineCustomElement: () => void;
