import type { Components, JSX } from "../types/components";

interface ScUpgradeRequired extends Components.ScUpgradeRequired, HTMLElement {}
export const ScUpgradeRequired: {
    prototype: ScUpgradeRequired;
    new (): ScUpgradeRequired;
};
/**
 * Used to define this component and all nested components recursively.
 */
export const defineCustomElement: () => void;
