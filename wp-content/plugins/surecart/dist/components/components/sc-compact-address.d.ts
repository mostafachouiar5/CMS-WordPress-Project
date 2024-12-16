import type { Components, JSX } from "../types/components";

interface ScCompactAddress extends Components.ScCompactAddress, HTMLElement {}
export const ScCompactAddress: {
    prototype: ScCompactAddress;
    new (): ScCompactAddress;
};
/**
 * Used to define this component and all nested components recursively.
 */
export const defineCustomElement: () => void;
