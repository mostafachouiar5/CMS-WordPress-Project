import type { Components, JSX } from "../types/components";

interface ScRichText extends Components.ScRichText, HTMLElement {}
export const ScRichText: {
    prototype: ScRichText;
    new (): ScRichText;
};
/**
 * Used to define this component and all nested components recursively.
 */
export const defineCustomElement: () => void;
