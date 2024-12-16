import type { Components, JSX } from "../types/components";

interface ScBadgeNotice extends Components.ScBadgeNotice, HTMLElement {}
export const ScBadgeNotice: {
    prototype: ScBadgeNotice;
    new (): ScBadgeNotice;
};
/**
 * Used to define this component and all nested components recursively.
 */
export const defineCustomElement: () => void;
