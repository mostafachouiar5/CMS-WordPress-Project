import type { Components, JSX } from "../types/components";

interface ScCard extends Components.ScCard, HTMLElement {}
export const ScCard: {
    prototype: ScCard;
    new (): ScCard;
};
/**
 * Used to define this component and all nested components recursively.
 */
export const defineCustomElement: () => void;
