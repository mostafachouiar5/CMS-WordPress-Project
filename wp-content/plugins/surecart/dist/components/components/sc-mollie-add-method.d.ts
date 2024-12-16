import type { Components, JSX } from "../types/components";

interface ScMollieAddMethod extends Components.ScMollieAddMethod, HTMLElement {}
export const ScMollieAddMethod: {
    prototype: ScMollieAddMethod;
    new (): ScMollieAddMethod;
};
/**
 * Used to define this component and all nested components recursively.
 */
export const defineCustomElement: () => void;
