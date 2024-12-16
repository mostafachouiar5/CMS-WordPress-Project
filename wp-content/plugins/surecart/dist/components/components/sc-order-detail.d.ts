import type { Components, JSX } from "../types/components";

interface ScOrderDetail extends Components.ScOrderDetail, HTMLElement {}
export const ScOrderDetail: {
    prototype: ScOrderDetail;
    new (): ScOrderDetail;
};
/**
 * Used to define this component and all nested components recursively.
 */
export const defineCustomElement: () => void;
