import type { Components, JSX } from "../types/components";

interface ScConditionalForm extends Components.ScConditionalForm, HTMLElement {}
export const ScConditionalForm: {
    prototype: ScConditionalForm;
    new (): ScConditionalForm;
};
/**
 * Used to define this component and all nested components recursively.
 */
export const defineCustomElement: () => void;
