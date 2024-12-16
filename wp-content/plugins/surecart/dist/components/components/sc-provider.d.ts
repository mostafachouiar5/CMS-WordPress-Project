import type { Components, JSX } from "../types/components";

interface ScProvider extends Components.ScProvider, HTMLElement {}
export const ScProvider: {
    prototype: ScProvider;
    new (): ScProvider;
};
/**
 * Used to define this component and all nested components recursively.
 */
export const defineCustomElement: () => void;
