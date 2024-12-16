import type { Components, JSX } from "../types/components";

interface ScFormStateProvider extends Components.ScFormStateProvider, HTMLElement {}
export const ScFormStateProvider: {
    prototype: ScFormStateProvider;
    new (): ScFormStateProvider;
};
/**
 * Used to define this component and all nested components recursively.
 */
export const defineCustomElement: () => void;
