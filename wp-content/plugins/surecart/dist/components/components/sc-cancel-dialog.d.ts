import type { Components, JSX } from "../types/components";

interface ScCancelDialog extends Components.ScCancelDialog, HTMLElement {}
export const ScCancelDialog: {
    prototype: ScCancelDialog;
    new (): ScCancelDialog;
};
/**
 * Used to define this component and all nested components recursively.
 */
export const defineCustomElement: () => void;
