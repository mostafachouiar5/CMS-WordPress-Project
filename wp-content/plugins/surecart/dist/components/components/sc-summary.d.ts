import type { Components, JSX } from "../types/components";

interface ScSummary extends Components.ScSummary, HTMLElement {}
export const ScSummary: {
    prototype: ScSummary;
    new (): ScSummary;
};
/**
 * Used to define this component and all nested components recursively.
 */
export const defineCustomElement: () => void;
