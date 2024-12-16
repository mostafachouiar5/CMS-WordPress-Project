import type { Components, JSX } from "../types/components";

interface ScCustomerEmail extends Components.ScCustomerEmail, HTMLElement {}
export const ScCustomerEmail: {
    prototype: ScCustomerEmail;
    new (): ScCustomerEmail;
};
/**
 * Used to define this component and all nested components recursively.
 */
export const defineCustomElement: () => void;
