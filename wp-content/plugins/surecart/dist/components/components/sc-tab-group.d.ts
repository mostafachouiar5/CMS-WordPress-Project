import type { Components, JSX } from "../types/components";

interface ScTabGroup extends Components.ScTabGroup, HTMLElement {}
export const ScTabGroup: {
    prototype: ScTabGroup;
    new (): ScTabGroup;
};
/**
 * Used to define this component and all nested components recursively.
 */
export const defineCustomElement: () => void;
