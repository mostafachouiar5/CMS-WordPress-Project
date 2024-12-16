import type { Components, JSX } from "../types/components";

interface ScButtonGroup extends Components.ScButtonGroup, HTMLElement {}
export const ScButtonGroup: {
    prototype: ScButtonGroup;
    new (): ScButtonGroup;
};
/**
 * Used to define this component and all nested components recursively.
 */
export const defineCustomElement: () => void;
