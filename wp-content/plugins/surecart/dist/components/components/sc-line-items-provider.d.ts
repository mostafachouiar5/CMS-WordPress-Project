import type { Components, JSX } from "../types/components";

interface ScLineItemsProvider extends Components.ScLineItemsProvider, HTMLElement {}
export const ScLineItemsProvider: {
    prototype: ScLineItemsProvider;
    new (): ScLineItemsProvider;
};
/**
 * Used to define this component and all nested components recursively.
 */
export const defineCustomElement: () => void;
