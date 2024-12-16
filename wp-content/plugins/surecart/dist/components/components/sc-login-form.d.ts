import type { Components, JSX } from "../types/components";

interface ScLoginForm extends Components.ScLoginForm, HTMLElement {}
export const ScLoginForm: {
    prototype: ScLoginForm;
    new (): ScLoginForm;
};
/**
 * Used to define this component and all nested components recursively.
 */
export const defineCustomElement: () => void;
