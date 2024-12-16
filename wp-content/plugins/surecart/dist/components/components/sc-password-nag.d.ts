import type { Components, JSX } from "../types/components";

interface ScPasswordNag extends Components.ScPasswordNag, HTMLElement {}
export const ScPasswordNag: {
    prototype: ScPasswordNag;
    new (): ScPasswordNag;
};
/**
 * Used to define this component and all nested components recursively.
 */
export const defineCustomElement: () => void;
