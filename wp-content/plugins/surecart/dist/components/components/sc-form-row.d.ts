import type { Components, JSX } from "../types/components";

interface ScFormRow extends Components.ScFormRow, HTMLElement {}
export const ScFormRow: {
    prototype: ScFormRow;
    new (): ScFormRow;
};
/**
 * Used to define this component and all nested components recursively.
 */
export const defineCustomElement: () => void;
