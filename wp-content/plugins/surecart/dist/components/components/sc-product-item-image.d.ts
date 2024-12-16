import type { Components, JSX } from "../types/components";

interface ScProductItemImage extends Components.ScProductItemImage, HTMLElement {}
export const ScProductItemImage: {
    prototype: ScProductItemImage;
    new (): ScProductItemImage;
};
/**
 * Used to define this component and all nested components recursively.
 */
export const defineCustomElement: () => void;
