import type { Components, JSX } from "../types/components";

interface ScTab extends Components.ScTab, HTMLElement {}
export const ScTab: {
    prototype: ScTab;
    new (): ScTab;
};
/**
 * Used to define this component and all nested components recursively.
 */
export const defineCustomElement: () => void;
