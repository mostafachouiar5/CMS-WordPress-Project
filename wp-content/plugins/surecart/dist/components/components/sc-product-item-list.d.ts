import type { Components, JSX } from "../types/components";

interface ScProductItemList extends Components.ScProductItemList, HTMLElement {}
export const ScProductItemList: {
    prototype: ScProductItemList;
    new (): ScProductItemList;
};
/**
 * Used to define this component and all nested components recursively.
 */
export const defineCustomElement: () => void;
