import type { Components, JSX } from "../types/components";

interface ScDivider extends Components.ScDivider, HTMLElement {}
export const ScDivider: {
    prototype: ScDivider;
    new (): ScDivider;
};
/**
 * Used to define this component and all nested components recursively.
 */
export const defineCustomElement: () => void;
