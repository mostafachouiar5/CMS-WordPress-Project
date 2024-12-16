import type { Components, JSX } from "../types/components";

interface ScCcLogo extends Components.ScCcLogo, HTMLElement {}
export const ScCcLogo: {
    prototype: ScCcLogo;
    new (): ScCcLogo;
};
/**
 * Used to define this component and all nested components recursively.
 */
export const defineCustomElement: () => void;
