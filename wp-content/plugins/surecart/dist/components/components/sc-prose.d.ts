import type { Components, JSX } from "../types/components";

interface ScProse extends Components.ScProse, HTMLElement {}
export const ScProse: {
    prototype: ScProse;
    new (): ScProse;
};
/**
 * Used to define this component and all nested components recursively.
 */
export const defineCustomElement: () => void;
