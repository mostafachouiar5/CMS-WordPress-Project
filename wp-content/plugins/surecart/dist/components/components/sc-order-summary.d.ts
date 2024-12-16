import type { Components, JSX } from "../types/components";

interface ScOrderSummary extends Components.ScOrderSummary, HTMLElement {}
export const ScOrderSummary: {
    prototype: ScOrderSummary;
    new (): ScOrderSummary;
};
/**
 * Used to define this component and all nested components recursively.
 */
export const defineCustomElement: () => void;
