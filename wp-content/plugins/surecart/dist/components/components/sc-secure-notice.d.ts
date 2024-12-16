import type { Components, JSX } from "../types/components";

interface ScSecureNotice extends Components.ScSecureNotice, HTMLElement {}
export const ScSecureNotice: {
    prototype: ScSecureNotice;
    new (): ScSecureNotice;
};
/**
 * Used to define this component and all nested components recursively.
 */
export const defineCustomElement: () => void;
