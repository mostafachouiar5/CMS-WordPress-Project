import type { Components, JSX } from "../types/components";

interface ScTableCell extends Components.ScTableCell, HTMLElement {}
export const ScTableCell: {
    prototype: ScTableCell;
    new (): ScTableCell;
};
/**
 * Used to define this component and all nested components recursively.
 */
export const defineCustomElement: () => void;
