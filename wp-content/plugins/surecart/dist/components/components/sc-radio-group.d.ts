import type { Components, JSX } from "../types/components";

interface ScRadioGroup extends Components.ScRadioGroup, HTMLElement {}
export const ScRadioGroup: {
    prototype: ScRadioGroup;
    new (): ScRadioGroup;
};
/**
 * Used to define this component and all nested components recursively.
 */
export const defineCustomElement: () => void;
