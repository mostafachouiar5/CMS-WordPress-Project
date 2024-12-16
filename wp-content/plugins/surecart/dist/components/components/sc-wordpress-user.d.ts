import type { Components, JSX } from "../types/components";

interface ScWordpressUser extends Components.ScWordpressUser, HTMLElement {}
export const ScWordpressUser: {
    prototype: ScWordpressUser;
    new (): ScWordpressUser;
};
/**
 * Used to define this component and all nested components recursively.
 */
export const defineCustomElement: () => void;
