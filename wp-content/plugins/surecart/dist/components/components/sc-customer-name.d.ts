import type { Components, JSX } from "../types/components";

interface ScCustomerName extends Components.ScCustomerName, HTMLElement {}
export const ScCustomerName: {
    prototype: ScCustomerName;
    new (): ScCustomerName;
};
/**
 * Used to define this component and all nested components recursively.
 */
export const defineCustomElement: () => void;
