import type { Components, JSX } from "../types/components";

interface ScPremiumTag extends Components.ScPremiumTag, HTMLElement {}
export const ScPremiumTag: {
    prototype: ScPremiumTag;
    new (): ScPremiumTag;
};
/**
 * Used to define this component and all nested components recursively.
 */
export const defineCustomElement: () => void;
