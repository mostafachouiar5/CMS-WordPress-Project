import type { Components, JSX } from "../types/components";

interface ScVisuallyHidden extends Components.ScVisuallyHidden, HTMLElement {}
export const ScVisuallyHidden: {
    prototype: ScVisuallyHidden;
    new (): ScVisuallyHidden;
};
/**
 * Used to define this component and all nested components recursively.
 */
export const defineCustomElement: () => void;
