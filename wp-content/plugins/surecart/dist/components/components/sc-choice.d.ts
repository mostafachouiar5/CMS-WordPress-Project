import type { Components, JSX } from "../types/components";

interface ScChoice extends Components.ScChoice, HTMLElement {}
export const ScChoice: {
    prototype: ScChoice;
    new (): ScChoice;
};
/**
 * Used to define this component and all nested components recursively.
 */
export const defineCustomElement: () => void;
