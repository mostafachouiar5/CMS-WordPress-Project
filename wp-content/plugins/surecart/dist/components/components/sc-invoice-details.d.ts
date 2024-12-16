import type { Components, JSX } from "../types/components";

interface ScInvoiceDetails extends Components.ScInvoiceDetails, HTMLElement {}
export const ScInvoiceDetails: {
    prototype: ScInvoiceDetails;
    new (): ScInvoiceDetails;
};
/**
 * Used to define this component and all nested components recursively.
 */
export const defineCustomElement: () => void;
