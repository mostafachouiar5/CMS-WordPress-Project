import type { Components, JSX } from "../types/components";

interface ScInvoiceMemo extends Components.ScInvoiceMemo, HTMLElement {}
export const ScInvoiceMemo: {
    prototype: ScInvoiceMemo;
    new (): ScInvoiceMemo;
};
/**
 * Used to define this component and all nested components recursively.
 */
export const defineCustomElement: () => void;
