import type { Components, JSX } from "../types/components";

interface ScToggles extends Components.ScToggles, HTMLElement {}
export const ScToggles: {
    prototype: ScToggles;
    new (): ScToggles;
};
/**
 * Used to define this component and all nested components recursively.
 */
export const defineCustomElement: () => void;
