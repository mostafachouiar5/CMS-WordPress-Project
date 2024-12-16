import type { Components, JSX } from "../types/components";

interface ScOrderBumps extends Components.ScOrderBumps, HTMLElement {}
export const ScOrderBumps: {
    prototype: ScOrderBumps;
    new (): ScOrderBumps;
};
/**
 * Used to define this component and all nested components recursively.
 */
export const defineCustomElement: () => void;
