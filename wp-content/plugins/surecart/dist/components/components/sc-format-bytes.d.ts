import type { Components, JSX } from "../types/components";

interface ScFormatBytes extends Components.ScFormatBytes, HTMLElement {}
export const ScFormatBytes: {
    prototype: ScFormatBytes;
    new (): ScFormatBytes;
};
/**
 * Used to define this component and all nested components recursively.
 */
export const defineCustomElement: () => void;
