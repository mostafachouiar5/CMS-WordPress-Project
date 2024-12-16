import type { Components, JSX } from "../types/components";

interface ScCartButton extends Components.ScCartButton, HTMLElement {}
export const ScCartButton: {
    prototype: ScCartButton;
    new (): ScCartButton;
};
/**
 * Used to define this component and all nested components recursively.
 */
export const defineCustomElement: () => void;
