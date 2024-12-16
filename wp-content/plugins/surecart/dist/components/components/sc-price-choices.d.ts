import type { Components, JSX } from "../types/components";

interface ScPriceChoices extends Components.ScPriceChoices, HTMLElement {}
export const ScPriceChoices: {
    prototype: ScPriceChoices;
    new (): ScPriceChoices;
};
/**
 * Used to define this component and all nested components recursively.
 */
export const defineCustomElement: () => void;
