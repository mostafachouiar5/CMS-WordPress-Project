import type { Components, JSX } from "../types/components";

interface ScProductPriceChoices extends Components.ScProductPriceChoices, HTMLElement {}
export const ScProductPriceChoices: {
    prototype: ScProductPriceChoices;
    new (): ScProductPriceChoices;
};
/**
 * Used to define this component and all nested components recursively.
 */
export const defineCustomElement: () => void;
