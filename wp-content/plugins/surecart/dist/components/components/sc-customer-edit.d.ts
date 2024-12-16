import type { Components, JSX } from "../types/components";

interface ScCustomerEdit extends Components.ScCustomerEdit, HTMLElement {}
export const ScCustomerEdit: {
    prototype: ScCustomerEdit;
    new (): ScCustomerEdit;
};
/**
 * Used to define this component and all nested components recursively.
 */
export const defineCustomElement: () => void;
