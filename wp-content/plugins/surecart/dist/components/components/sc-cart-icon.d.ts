import type { Components, JSX } from "../types/components";

interface ScCartIcon extends Components.ScCartIcon, HTMLElement {}
export const ScCartIcon: {
    prototype: ScCartIcon;
    new (): ScCartIcon;
};
/**
 * Used to define this component and all nested components recursively.
 */
export const defineCustomElement: () => void;
