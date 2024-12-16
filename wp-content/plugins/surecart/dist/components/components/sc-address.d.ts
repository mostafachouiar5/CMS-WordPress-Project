import type { Components, JSX } from "../types/components";

interface ScAddress extends Components.ScAddress, HTMLElement {}
export const ScAddress: {
    prototype: ScAddress;
    new (): ScAddress;
};
/**
 * Used to define this component and all nested components recursively.
 */
export const defineCustomElement: () => void;
