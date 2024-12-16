import type { Components, JSX } from "../types/components";

interface ScCheckbox extends Components.ScCheckbox, HTMLElement {}
export const ScCheckbox: {
    prototype: ScCheckbox;
    new (): ScCheckbox;
};
/**
 * Used to define this component and all nested components recursively.
 */
export const defineCustomElement: () => void;
