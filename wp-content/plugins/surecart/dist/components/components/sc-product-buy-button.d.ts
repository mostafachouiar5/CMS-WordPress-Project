import type { Components, JSX } from "../types/components";

interface ScProductBuyButton extends Components.ScProductBuyButton, HTMLElement {}
export const ScProductBuyButton: {
    prototype: ScProductBuyButton;
    new (): ScProductBuyButton;
};
/**
 * Used to define this component and all nested components recursively.
 */
export const defineCustomElement: () => void;
