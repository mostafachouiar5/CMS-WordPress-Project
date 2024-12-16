import type { Components, JSX } from "../types/components";

interface ScCartHeader extends Components.ScCartHeader, HTMLElement {}
export const ScCartHeader: {
    prototype: ScCartHeader;
    new (): ScCartHeader;
};
/**
 * Used to define this component and all nested components recursively.
 */
export const defineCustomElement: () => void;
