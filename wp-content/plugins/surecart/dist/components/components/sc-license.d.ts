import type { Components, JSX } from "../types/components";

interface ScLicense extends Components.ScLicense, HTMLElement {}
export const ScLicense: {
    prototype: ScLicense;
    new (): ScLicense;
};
/**
 * Used to define this component and all nested components recursively.
 */
export const defineCustomElement: () => void;
