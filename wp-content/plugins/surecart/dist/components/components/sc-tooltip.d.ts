import type { Components, JSX } from "../types/components";

interface ScTooltip extends Components.ScTooltip, HTMLElement {}
export const ScTooltip: {
    prototype: ScTooltip;
    new (): ScTooltip;
};
/**
 * Used to define this component and all nested components recursively.
 */
export const defineCustomElement: () => void;
