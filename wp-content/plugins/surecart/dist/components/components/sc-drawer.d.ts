import type { Components, JSX } from "../types/components";

interface ScDrawer extends Components.ScDrawer, HTMLElement {}
export const ScDrawer: {
    prototype: ScDrawer;
    new (): ScDrawer;
};
/**
 * Used to define this component and all nested components recursively.
 */
export const defineCustomElement: () => void;
