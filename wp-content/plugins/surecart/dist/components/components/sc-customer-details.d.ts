import type { Components, JSX } from "../types/components";

interface ScCustomerDetails extends Components.ScCustomerDetails, HTMLElement {}
export const ScCustomerDetails: {
    prototype: ScCustomerDetails;
    new (): ScCustomerDetails;
};
/**
 * Used to define this component and all nested components recursively.
 */
export const defineCustomElement: () => void;
