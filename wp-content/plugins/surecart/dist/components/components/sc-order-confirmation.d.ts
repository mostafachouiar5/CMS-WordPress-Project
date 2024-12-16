import type { Components, JSX } from "../types/components";

interface ScOrderConfirmation extends Components.ScOrderConfirmation, HTMLElement {}
export const ScOrderConfirmation: {
    prototype: ScOrderConfirmation;
    new (): ScOrderConfirmation;
};
/**
 * Used to define this component and all nested components recursively.
 */
export const defineCustomElement: () => void;
