import type { Components, JSX } from "../types/components";

interface ScFormControl extends Components.ScFormControl, HTMLElement {}
export const ScFormControl: {
    prototype: ScFormControl;
    new (): ScFormControl;
};
/**
 * Used to define this component and all nested components recursively.
 */
export const defineCustomElement: () => void;
