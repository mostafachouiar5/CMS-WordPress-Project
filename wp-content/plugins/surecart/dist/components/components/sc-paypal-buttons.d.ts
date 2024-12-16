import type { Components, JSX } from "../types/components";

interface ScPaypalButtons extends Components.ScPaypalButtons, HTMLElement {}
export const ScPaypalButtons: {
    prototype: ScPaypalButtons;
    new (): ScPaypalButtons;
};
/**
 * Used to define this component and all nested components recursively.
 */
export const defineCustomElement: () => void;
