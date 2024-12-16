import type { Components, JSX } from "../types/components";

interface ScTableRow extends Components.ScTableRow, HTMLElement {}
export const ScTableRow: {
    prototype: ScTableRow;
    new (): ScTableRow;
};
/**
 * Used to define this component and all nested components recursively.
 */
export const defineCustomElement: () => void;
