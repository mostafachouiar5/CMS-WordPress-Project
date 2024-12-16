import type { Components, JSX } from "../types/components";

interface ScSubscriptionPayment extends Components.ScSubscriptionPayment, HTMLElement {}
export const ScSubscriptionPayment: {
    prototype: ScSubscriptionPayment;
    new (): ScSubscriptionPayment;
};
/**
 * Used to define this component and all nested components recursively.
 */
export const defineCustomElement: () => void;
