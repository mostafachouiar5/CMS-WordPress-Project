import type { Components, JSX } from "../types/components";

interface ScDialog extends Components.ScDialog, HTMLElement {}
export const ScDialog: {
    prototype: ScDialog;
    new (): ScDialog;
};
/**
 * Used to define this component and all nested components recursively.
 */
export const defineCustomElement: () => void;
