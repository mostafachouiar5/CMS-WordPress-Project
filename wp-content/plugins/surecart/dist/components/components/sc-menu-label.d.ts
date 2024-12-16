import type { Components, JSX } from "../types/components";

interface ScMenuLabel extends Components.ScMenuLabel, HTMLElement {}
export const ScMenuLabel: {
    prototype: ScMenuLabel;
    new (): ScMenuLabel;
};
/**
 * Used to define this component and all nested components recursively.
 */
export const defineCustomElement: () => void;
