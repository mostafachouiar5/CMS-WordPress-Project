import type { Components, JSX } from "../types/components";

interface ScCartLoader extends Components.ScCartLoader, HTMLElement {}
export const ScCartLoader: {
    prototype: ScCartLoader;
    new (): ScCartLoader;
};
/**
 * Used to define this component and all nested components recursively.
 */
export const defineCustomElement: () => void;
