import type { Components, JSX } from "../types/components";

interface ScPriceChoice extends Components.ScPriceChoice, HTMLElement {}
export const ScPriceChoice: {
    prototype: ScPriceChoice;
    new (): ScPriceChoice;
};
/**
 * Used to define this component and all nested components recursively.
 */
export const defineCustomElement: () => void;
