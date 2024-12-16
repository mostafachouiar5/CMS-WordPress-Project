import type { Components, JSX } from "../types/components";

interface ScPagination extends Components.ScPagination, HTMLElement {}
export const ScPagination: {
    prototype: ScPagination;
    new (): ScPagination;
};
/**
 * Used to define this component and all nested components recursively.
 */
export const defineCustomElement: () => void;
