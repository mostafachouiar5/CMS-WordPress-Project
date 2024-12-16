import type { Components, JSX } from "../types/components";

interface ScButton extends Components.ScButton, HTMLElement {}
export const ScButton: {
    prototype: ScButton;
    new (): ScButton;
};
/**
 * Used to define this component and all nested components recursively.
 */
export const defineCustomElement: () => void;
