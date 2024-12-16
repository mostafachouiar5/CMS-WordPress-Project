import type { Components, JSX } from "../types/components";

interface ScBreadcrumbs extends Components.ScBreadcrumbs, HTMLElement {}
export const ScBreadcrumbs: {
    prototype: ScBreadcrumbs;
    new (): ScBreadcrumbs;
};
/**
 * Used to define this component and all nested components recursively.
 */
export const defineCustomElement: () => void;
