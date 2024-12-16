import type { Components, JSX } from "../types/components";

interface ScStackedListRow extends Components.ScStackedListRow, HTMLElement {}
export const ScStackedListRow: {
    prototype: ScStackedListRow;
    new (): ScStackedListRow;
};
/**
 * Used to define this component and all nested components recursively.
 */
export const defineCustomElement: () => void;
