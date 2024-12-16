import type { Components, JSX } from "../types/components";

interface ScDashboardModule extends Components.ScDashboardModule, HTMLElement {}
export const ScDashboardModule: {
    prototype: ScDashboardModule;
    new (): ScDashboardModule;
};
/**
 * Used to define this component and all nested components recursively.
 */
export const defineCustomElement: () => void;
