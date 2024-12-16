import type { Components, JSX } from "../types/components";

interface ScEmpty extends Components.ScEmpty, HTMLElement {}
export const ScEmpty: {
    prototype: ScEmpty;
    new (): ScEmpty;
};
/**
 * Used to define this component and all nested components recursively.
 */
export const defineCustomElement: () => void;
