import type { Components, JSX } from "../types/components";

interface ScDownloadsList extends Components.ScDownloadsList, HTMLElement {}
export const ScDownloadsList: {
    prototype: ScDownloadsList;
    new (): ScDownloadsList;
};
/**
 * Used to define this component and all nested components recursively.
 */
export const defineCustomElement: () => void;
