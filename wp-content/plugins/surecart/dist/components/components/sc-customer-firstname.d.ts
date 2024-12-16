import type { Components, JSX } from "../types/components";

interface ScCustomerFirstname extends Components.ScCustomerFirstname, HTMLElement {}
export const ScCustomerFirstname: {
    prototype: ScCustomerFirstname;
    new (): ScCustomerFirstname;
};
/**
 * Used to define this component and all nested components recursively.
 */
export const defineCustomElement: () => void;
