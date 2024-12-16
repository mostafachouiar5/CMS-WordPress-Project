import type { Components, JSX } from "../types/components";

interface ScColumns extends Components.ScColumns, HTMLElement {}
export const ScColumns: {
    prototype: ScColumns;
    new (): ScColumns;
};
/**
 * Used to define this component and all nested components recursively.
 */
export const defineCustomElement: () => void;
