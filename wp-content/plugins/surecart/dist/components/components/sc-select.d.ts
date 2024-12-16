import type { Components, JSX } from "../types/components";

interface ScSelect extends Components.ScSelect, HTMLElement {}
export const ScSelect: {
    prototype: ScSelect;
    new (): ScSelect;
};
/**
 * Used to define this component and all nested components recursively.
 */
export const defineCustomElement: () => void;
