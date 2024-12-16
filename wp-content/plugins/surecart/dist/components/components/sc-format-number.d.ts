import type { Components, JSX } from "../types/components";

interface ScFormatNumber extends Components.ScFormatNumber, HTMLElement {}
export const ScFormatNumber: {
    prototype: ScFormatNumber;
    new (): ScFormatNumber;
};
/**
 * Used to define this component and all nested components recursively.
 */
export const defineCustomElement: () => void;
