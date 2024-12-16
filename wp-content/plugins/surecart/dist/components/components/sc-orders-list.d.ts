import type { Components, JSX } from "../types/components";

interface ScOrdersList extends Components.ScOrdersList, HTMLElement {}
export const ScOrdersList: {
    prototype: ScOrdersList;
    new (): ScOrdersList;
};
/**
 * Used to define this component and all nested components recursively.
 */
export const defineCustomElement: () => void;
