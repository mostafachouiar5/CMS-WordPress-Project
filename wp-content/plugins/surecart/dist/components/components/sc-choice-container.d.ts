import type { Components, JSX } from "../types/components";

interface ScChoiceContainer extends Components.ScChoiceContainer, HTMLElement {}
export const ScChoiceContainer: {
    prototype: ScChoiceContainer;
    new (): ScChoiceContainer;
};
/**
 * Used to define this component and all nested components recursively.
 */
export const defineCustomElement: () => void;
