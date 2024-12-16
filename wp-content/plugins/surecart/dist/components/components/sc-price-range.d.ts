import type { Components, JSX } from "../types/components";

interface ScPriceRange extends Components.ScPriceRange, HTMLElement {}
export const ScPriceRange: {
    prototype: ScPriceRange;
    new (): ScPriceRange;
};
/**
 * Used to define this component and all nested components recursively.
 */
export const defineCustomElement: () => void;
