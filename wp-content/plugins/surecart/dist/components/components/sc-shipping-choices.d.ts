import type { Components, JSX } from "../types/components";

interface ScShippingChoices extends Components.ScShippingChoices, HTMLElement {}
export const ScShippingChoices: {
    prototype: ScShippingChoices;
    new (): ScShippingChoices;
};
/**
 * Used to define this component and all nested components recursively.
 */
export const defineCustomElement: () => void;
