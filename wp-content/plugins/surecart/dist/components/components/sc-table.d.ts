import type { Components, JSX } from "../types/components";

interface ScTable extends Components.ScTable, HTMLElement {}
export const ScTable: {
    prototype: ScTable;
    new (): ScTable;
};
/**
 * Used to define this component and all nested components recursively.
 */
export const defineCustomElement: () => void;
