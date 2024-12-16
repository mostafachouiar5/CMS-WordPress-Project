import type { Components, JSX } from "../types/components";

interface ScSubscriptionsList extends Components.ScSubscriptionsList, HTMLElement {}
export const ScSubscriptionsList: {
    prototype: ScSubscriptionsList;
    new (): ScSubscriptionsList;
};
/**
 * Used to define this component and all nested components recursively.
 */
export const defineCustomElement: () => void;
