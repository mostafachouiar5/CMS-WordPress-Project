import type { Components, JSX } from "../types/components";

interface ScAlert extends Components.ScAlert, HTMLElement {}
export const ScAlert: {
    prototype: ScAlert;
    new (): ScAlert;
};
/**
 * Used to define this component and all nested components recursively.
 */
export const defineCustomElement: () => void;
