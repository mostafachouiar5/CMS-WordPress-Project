import type { Components, JSX } from "../types/components";

interface ScFlex extends Components.ScFlex, HTMLElement {}
export const ScFlex: {
    prototype: ScFlex;
    new (): ScFlex;
};
/**
 * Used to define this component and all nested components recursively.
 */
export const defineCustomElement: () => void;
