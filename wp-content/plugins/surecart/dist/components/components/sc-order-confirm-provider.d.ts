import type { Components, JSX } from "../types/components";

interface ScOrderConfirmProvider extends Components.ScOrderConfirmProvider, HTMLElement {}
export const ScOrderConfirmProvider: {
    prototype: ScOrderConfirmProvider;
    new (): ScOrderConfirmProvider;
};
/**
 * Used to define this component and all nested components recursively.
 */
export const defineCustomElement: () => void;
