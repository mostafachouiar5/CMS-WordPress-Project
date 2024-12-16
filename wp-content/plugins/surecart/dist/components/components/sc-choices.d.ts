import type { Components, JSX } from "../types/components";

interface ScChoices extends Components.ScChoices, HTMLElement {}
export const ScChoices: {
    prototype: ScChoices;
    new (): ScChoices;
};
/**
 * Used to define this component and all nested components recursively.
 */
export const defineCustomElement: () => void;
