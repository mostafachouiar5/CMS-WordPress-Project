import type { Components, JSX } from "../types/components";

interface ScOrderBump extends Components.ScOrderBump, HTMLElement {}
export const ScOrderBump: {
    prototype: ScOrderBump;
    new (): ScOrderBump;
};
/**
 * Used to define this component and all nested components recursively.
 */
export const defineCustomElement: () => void;
