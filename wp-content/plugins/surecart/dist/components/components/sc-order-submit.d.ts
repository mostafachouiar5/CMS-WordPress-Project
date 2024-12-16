import type { Components, JSX } from "../types/components";

interface ScOrderSubmit extends Components.ScOrderSubmit, HTMLElement {}
export const ScOrderSubmit: {
    prototype: ScOrderSubmit;
    new (): ScOrderSubmit;
};
/**
 * Used to define this component and all nested components recursively.
 */
export const defineCustomElement: () => void;
