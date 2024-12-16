import type { Components, JSX } from "../types/components";

interface ScFormatDate extends Components.ScFormatDate, HTMLElement {}
export const ScFormatDate: {
    prototype: ScFormatDate;
    new (): ScFormatDate;
};
/**
 * Used to define this component and all nested components recursively.
 */
export const defineCustomElement: () => void;
