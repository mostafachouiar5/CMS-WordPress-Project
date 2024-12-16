import type { Components, JSX } from "../types/components";

interface ScDropdown extends Components.ScDropdown, HTMLElement {}
export const ScDropdown: {
    prototype: ScDropdown;
    new (): ScDropdown;
};
/**
 * Used to define this component and all nested components recursively.
 */
export const defineCustomElement: () => void;
