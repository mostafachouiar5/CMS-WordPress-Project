import type { Components, JSX } from "../types/components";

interface ScCartSubmit extends Components.ScCartSubmit, HTMLElement {}
export const ScCartSubmit: {
    prototype: ScCartSubmit;
    new (): ScCartSubmit;
};
/**
 * Used to define this component and all nested components recursively.
 */
export const defineCustomElement: () => void;
