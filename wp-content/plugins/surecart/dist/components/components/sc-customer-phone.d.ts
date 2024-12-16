import type { Components, JSX } from "../types/components";

interface ScCustomerPhone extends Components.ScCustomerPhone, HTMLElement {}
export const ScCustomerPhone: {
    prototype: ScCustomerPhone;
    new (): ScCustomerPhone;
};
/**
 * Used to define this component and all nested components recursively.
 */
export const defineCustomElement: () => void;
