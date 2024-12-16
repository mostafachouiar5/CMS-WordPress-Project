import type { Components, JSX } from "../types/components";

interface ScColumn extends Components.ScColumn, HTMLElement {}
export const ScColumn: {
    prototype: ScColumn;
    new (): ScColumn;
};
/**
 * Used to define this component and all nested components recursively.
 */
export const defineCustomElement: () => void;
