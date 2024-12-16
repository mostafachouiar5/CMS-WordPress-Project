import type { Components, JSX } from "../types/components";

interface ScRadio extends Components.ScRadio, HTMLElement {}
export const ScRadio: {
    prototype: ScRadio;
    new (): ScRadio;
};
/**
 * Used to define this component and all nested components recursively.
 */
export const defineCustomElement: () => void;
