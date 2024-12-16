import type { Components, JSX } from "../types/components";

interface ScInvoicesList extends Components.ScInvoicesList, HTMLElement {}
export const ScInvoicesList: {
    prototype: ScInvoicesList;
    new (): ScInvoicesList;
};
/**
 * Used to define this component and all nested components recursively.
 */
export const defineCustomElement: () => void;
