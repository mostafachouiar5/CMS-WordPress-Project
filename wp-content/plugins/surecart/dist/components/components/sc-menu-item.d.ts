import type { Components, JSX } from "../types/components";

interface ScMenuItem extends Components.ScMenuItem, HTMLElement {}
export const ScMenuItem: {
    prototype: ScMenuItem;
    new (): ScMenuItem;
};
/**
 * Used to define this component and all nested components recursively.
 */
export const defineCustomElement: () => void;
