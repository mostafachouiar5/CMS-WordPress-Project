import type { Components, JSX } from "../types/components";

interface ScCartForm extends Components.ScCartForm, HTMLElement {}
export const ScCartForm: {
    prototype: ScCartForm;
    new (): ScCartForm;
};
/**
 * Used to define this component and all nested components recursively.
 */
export const defineCustomElement: () => void;
