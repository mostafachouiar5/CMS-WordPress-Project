import type { Components, JSX } from "../types/components";

interface ScIcon extends Components.ScIcon, HTMLElement {}
export const ScIcon: {
    prototype: ScIcon;
    new (): ScIcon;
};
/**
 * Used to define this component and all nested components recursively.
 */
export const defineCustomElement: () => void;
