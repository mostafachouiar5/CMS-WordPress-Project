import type { Components, JSX } from "../types/components";

interface ScStackedList extends Components.ScStackedList, HTMLElement {}
export const ScStackedList: {
    prototype: ScStackedList;
    new (): ScStackedList;
};
/**
 * Used to define this component and all nested components recursively.
 */
export const defineCustomElement: () => void;
