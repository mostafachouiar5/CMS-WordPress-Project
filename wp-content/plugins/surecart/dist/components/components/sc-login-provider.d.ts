import type { Components, JSX } from "../types/components";

interface ScLoginProvider extends Components.ScLoginProvider, HTMLElement {}
export const ScLoginProvider: {
    prototype: ScLoginProvider;
    new (): ScLoginProvider;
};
/**
 * Used to define this component and all nested components recursively.
 */
export const defineCustomElement: () => void;
