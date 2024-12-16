import type { Components, JSX } from "../types/components";

interface ScTableHead extends Components.ScTableHead, HTMLElement {}
export const ScTableHead: {
    prototype: ScTableHead;
    new (): ScTableHead;
};
/**
 * Used to define this component and all nested components recursively.
 */
export const defineCustomElement: () => void;
