import type { Components, JSX } from "../types/components";

interface ScSpacing extends Components.ScSpacing, HTMLElement {}
export const ScSpacing: {
    prototype: ScSpacing;
    new (): ScSpacing;
};
/**
 * Used to define this component and all nested components recursively.
 */
export const defineCustomElement: () => void;
