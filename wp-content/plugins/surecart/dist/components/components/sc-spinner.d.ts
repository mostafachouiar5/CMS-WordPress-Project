import type { Components, JSX } from "../types/components";

interface ScSpinner extends Components.ScSpinner, HTMLElement {}
export const ScSpinner: {
    prototype: ScSpinner;
    new (): ScSpinner;
};
/**
 * Used to define this component and all nested components recursively.
 */
export const defineCustomElement: () => void;
