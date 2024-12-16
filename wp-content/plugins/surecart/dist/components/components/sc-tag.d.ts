import type { Components, JSX } from "../types/components";

interface ScTag extends Components.ScTag, HTMLElement {}
export const ScTag: {
    prototype: ScTag;
    new (): ScTag;
};
/**
 * Used to define this component and all nested components recursively.
 */
export const defineCustomElement: () => void;
