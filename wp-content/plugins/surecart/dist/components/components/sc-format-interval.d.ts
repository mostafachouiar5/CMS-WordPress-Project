import type { Components, JSX } from "../types/components";

interface ScFormatInterval extends Components.ScFormatInterval, HTMLElement {}
export const ScFormatInterval: {
    prototype: ScFormatInterval;
    new (): ScFormatInterval;
};
/**
 * Used to define this component and all nested components recursively.
 */
export const defineCustomElement: () => void;
