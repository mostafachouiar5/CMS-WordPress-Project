import type { Components, JSX } from "../types/components";

interface ScOrder extends Components.ScOrder, HTMLElement {}
export const ScOrder: {
    prototype: ScOrder;
    new (): ScOrder;
};
/**
 * Used to define this component and all nested components recursively.
 */
export const defineCustomElement: () => void;
