import type { Components, JSX } from "../types/components";

interface ScSessionProvider extends Components.ScSessionProvider, HTMLElement {}
export const ScSessionProvider: {
    prototype: ScSessionProvider;
    new (): ScSessionProvider;
};
/**
 * Used to define this component and all nested components recursively.
 */
export const defineCustomElement: () => void;
