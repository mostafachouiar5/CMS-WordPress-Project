import type { Components, JSX } from "../types/components";

interface ScMenuDivider extends Components.ScMenuDivider, HTMLElement {}
export const ScMenuDivider: {
    prototype: ScMenuDivider;
    new (): ScMenuDivider;
};
/**
 * Used to define this component and all nested components recursively.
 */
export const defineCustomElement: () => void;
