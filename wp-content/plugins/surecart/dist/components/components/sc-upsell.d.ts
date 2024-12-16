import type { Components, JSX } from "../types/components";

interface ScUpsell extends Components.ScUpsell, HTMLElement {}
export const ScUpsell: {
    prototype: ScUpsell;
    new (): ScUpsell;
};
/**
 * Used to define this component and all nested components recursively.
 */
export const defineCustomElement: () => void;
