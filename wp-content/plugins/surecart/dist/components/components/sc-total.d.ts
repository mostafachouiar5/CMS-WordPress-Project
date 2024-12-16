import type { Components, JSX } from "../types/components";

interface ScTotal extends Components.ScTotal, HTMLElement {}
export const ScTotal: {
    prototype: ScTotal;
    new (): ScTotal;
};
/**
 * Used to define this component and all nested components recursively.
 */
export const defineCustomElement: () => void;
