import type { Components, JSX } from "../types/components";

interface ScFulfillments extends Components.ScFulfillments, HTMLElement {}
export const ScFulfillments: {
    prototype: ScFulfillments;
    new (): ScFulfillments;
};
/**
 * Used to define this component and all nested components recursively.
 */
export const defineCustomElement: () => void;
