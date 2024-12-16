import type { Components, JSX } from "../types/components";

interface ScFormComponentsValidator extends Components.ScFormComponentsValidator, HTMLElement {}
export const ScFormComponentsValidator: {
    prototype: ScFormComponentsValidator;
    new (): ScFormComponentsValidator;
};
/**
 * Used to define this component and all nested components recursively.
 */
export const defineCustomElement: () => void;
