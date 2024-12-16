import type { Components, JSX } from "../types/components";

interface ScTabPanel extends Components.ScTabPanel, HTMLElement {}
export const ScTabPanel: {
    prototype: ScTabPanel;
    new (): ScTabPanel;
};
/**
 * Used to define this component and all nested components recursively.
 */
export const defineCustomElement: () => void;
