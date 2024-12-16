import type { Components, JSX } from "../types/components";

interface ScMenu extends Components.ScMenu, HTMLElement {}
export const ScMenu: {
    prototype: ScMenu;
    new (): ScMenu;
};
/**
 * Used to define this component and all nested components recursively.
 */
export const defineCustomElement: () => void;
