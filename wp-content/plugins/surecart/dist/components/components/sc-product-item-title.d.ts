import type { Components, JSX } from "../types/components";

interface ScProductItemTitle extends Components.ScProductItemTitle, HTMLElement {}
export const ScProductItemTitle: {
    prototype: ScProductItemTitle;
    new (): ScProductItemTitle;
};
/**
 * Used to define this component and all nested components recursively.
 */
export const defineCustomElement: () => void;
