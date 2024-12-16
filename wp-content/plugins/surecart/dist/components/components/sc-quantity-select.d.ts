import type { Components, JSX } from "../types/components";

interface ScQuantitySelect extends Components.ScQuantitySelect, HTMLElement {}
export const ScQuantitySelect: {
    prototype: ScQuantitySelect;
    new (): ScQuantitySelect;
};
/**
 * Used to define this component and all nested components recursively.
 */
export const defineCustomElement: () => void;
