import type { Components, JSX } from "../types/components";

interface ScLicensesList extends Components.ScLicensesList, HTMLElement {}
export const ScLicensesList: {
    prototype: ScLicensesList;
    new (): ScLicensesList;
};
/**
 * Used to define this component and all nested components recursively.
 */
export const defineCustomElement: () => void;
