import type { Components, JSX } from "../types/components";

interface ScManualPaymentMethod extends Components.ScManualPaymentMethod, HTMLElement {}
export const ScManualPaymentMethod: {
    prototype: ScManualPaymentMethod;
    new (): ScManualPaymentMethod;
};
/**
 * Used to define this component and all nested components recursively.
 */
export const defineCustomElement: () => void;
