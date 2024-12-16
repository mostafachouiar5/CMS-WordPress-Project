import type { Components, JSX } from "../types/components";

interface ScProductItem extends Components.ScProductItem, HTMLElement {}
export const ScProductItem: {
    prototype: ScProductItem;
    new (): ScProductItem;
};
/**
 * Used to define this component and all nested components recursively.
 */
export const defineCustomElement: () => void;
