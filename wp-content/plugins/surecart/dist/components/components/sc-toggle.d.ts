import type { Components, JSX } from "../types/components";

interface ScToggle extends Components.ScToggle, HTMLElement {}
export const ScToggle: {
    prototype: ScToggle;
    new (): ScToggle;
};
/**
 * Used to define this component and all nested components recursively.
 */
export const defineCustomElement: () => void;
