import type { Components, JSX } from "../types/components";

interface ScCouponForm extends Components.ScCouponForm, HTMLElement {}
export const ScCouponForm: {
    prototype: ScCouponForm;
    new (): ScCouponForm;
};
/**
 * Used to define this component and all nested components recursively.
 */
export const defineCustomElement: () => void;
