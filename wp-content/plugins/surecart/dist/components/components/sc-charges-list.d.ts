import type { Components, JSX } from "../types/components";

interface ScChargesList extends Components.ScChargesList, HTMLElement {}
export const ScChargesList: {
    prototype: ScChargesList;
    new (): ScChargesList;
};
/**
 * Used to define this component and all nested components recursively.
 */
export const defineCustomElement: () => void;
