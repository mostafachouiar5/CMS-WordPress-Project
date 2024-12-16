import type { Components, JSX } from "../types/components";

interface ScInput extends Components.ScInput, HTMLElement {}
export const ScInput: {
    prototype: ScInput;
    new (): ScInput;
};
/**
 * Used to define this component and all nested components recursively.
 */
export const defineCustomElement: () => void;
