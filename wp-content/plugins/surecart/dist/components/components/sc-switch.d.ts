import type { Components, JSX } from "../types/components";

interface ScSwitch extends Components.ScSwitch, HTMLElement {}
export const ScSwitch: {
    prototype: ScSwitch;
    new (): ScSwitch;
};
/**
 * Used to define this component and all nested components recursively.
 */
export const defineCustomElement: () => void;
