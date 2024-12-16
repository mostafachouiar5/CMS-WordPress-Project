import type { Components, JSX } from "../types/components";

interface ScCustomerLastname extends Components.ScCustomerLastname, HTMLElement {}
export const ScCustomerLastname: {
    prototype: ScCustomerLastname;
    new (): ScCustomerLastname;
};
/**
 * Used to define this component and all nested components recursively.
 */
export const defineCustomElement: () => void;
