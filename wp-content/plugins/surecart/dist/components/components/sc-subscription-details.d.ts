import type { Components, JSX } from "../types/components";

interface ScSubscriptionDetails extends Components.ScSubscriptionDetails, HTMLElement {}
export const ScSubscriptionDetails: {
    prototype: ScSubscriptionDetails;
    new (): ScSubscriptionDetails;
};
/**
 * Used to define this component and all nested components recursively.
 */
export const defineCustomElement: () => void;
