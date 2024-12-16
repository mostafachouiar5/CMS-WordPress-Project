import type { Components, JSX } from "../types/components";

interface ScCartSessionProvider extends Components.ScCartSessionProvider, HTMLElement {}
export const ScCartSessionProvider: {
    prototype: ScCartSessionProvider;
    new (): ScCartSessionProvider;
};
/**
 * Used to define this component and all nested components recursively.
 */
export const defineCustomElement: () => void;
