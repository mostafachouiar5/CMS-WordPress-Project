import type { Components, JSX } from "../types/components";

interface ScSubscription extends Components.ScSubscription, HTMLElement {}
export const ScSubscription: {
    prototype: ScSubscription;
    new (): ScSubscription;
};
/**
 * Used to define this component and all nested components recursively.
 */
export const defineCustomElement: () => void;
