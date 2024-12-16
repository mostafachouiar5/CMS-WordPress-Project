import type { Components, JSX } from "../types/components";

interface ScHeading extends Components.ScHeading, HTMLElement {}
export const ScHeading: {
    prototype: ScHeading;
    new (): ScHeading;
};
/**
 * Used to define this component and all nested components recursively.
 */
export const defineCustomElement: () => void;
