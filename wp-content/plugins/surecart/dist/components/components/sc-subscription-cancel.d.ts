import type { Components, JSX } from "../types/components";

interface ScSubscriptionCancel extends Components.ScSubscriptionCancel, HTMLElement {}
export const ScSubscriptionCancel: {
    prototype: ScSubscriptionCancel;
    new (): ScSubscriptionCancel;
};
/**
 * Used to define this component and all nested components recursively.
 */
export const defineCustomElement: () => void;
