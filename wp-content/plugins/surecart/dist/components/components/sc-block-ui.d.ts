import type { Components, JSX } from "../types/components";

interface ScBlockUi extends Components.ScBlockUi, HTMLElement {}
export const ScBlockUi: {
    prototype: ScBlockUi;
    new (): ScBlockUi;
};
/**
 * Used to define this component and all nested components recursively.
 */
export const defineCustomElement: () => void;
