import type { Components, JSX } from "../types/components";

interface ScProvisionalBanner extends Components.ScProvisionalBanner, HTMLElement {}
export const ScProvisionalBanner: {
    prototype: ScProvisionalBanner;
    new (): ScProvisionalBanner;
};
/**
 * Used to define this component and all nested components recursively.
 */
export const defineCustomElement: () => void;
