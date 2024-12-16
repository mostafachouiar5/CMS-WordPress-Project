import type { Components, JSX } from "../types/components";

interface ScForm extends Components.ScForm, HTMLElement {}
export const ScForm: {
    prototype: ScForm;
    new (): ScForm;
};
/**
 * Used to define this component and all nested components recursively.
 */
export const defineCustomElement: () => void;
