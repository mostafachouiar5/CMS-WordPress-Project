import type { Components, JSX } from "../types/components";

interface ScPillOption extends Components.ScPillOption, HTMLElement {}
export const ScPillOption: {
    prototype: ScPillOption;
    new (): ScPillOption;
};
/**
 * Used to define this component and all nested components recursively.
 */
export const defineCustomElement: () => void;
