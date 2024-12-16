import type { Components, JSX } from "../types/components";

interface ScPassword extends Components.ScPassword, HTMLElement {}
export const ScPassword: {
    prototype: ScPassword;
    new (): ScPassword;
};
/**
 * Used to define this component and all nested components recursively.
 */
export const defineCustomElement: () => void;
