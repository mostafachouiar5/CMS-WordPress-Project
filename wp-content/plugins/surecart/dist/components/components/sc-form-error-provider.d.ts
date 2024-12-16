import type { Components, JSX } from "../types/components";

interface ScFormErrorProvider extends Components.ScFormErrorProvider, HTMLElement {}
export const ScFormErrorProvider: {
    prototype: ScFormErrorProvider;
    new (): ScFormErrorProvider;
};
/**
 * Used to define this component and all nested components recursively.
 */
export const defineCustomElement: () => void;
