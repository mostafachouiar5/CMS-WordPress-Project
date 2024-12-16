import type { Components, JSX } from "../types/components";

interface ScError extends Components.ScError, HTMLElement {}
export const ScError: {
    prototype: ScError;
    new (): ScError;
};
/**
 * Used to define this component and all nested components recursively.
 */
export const defineCustomElement: () => void;
