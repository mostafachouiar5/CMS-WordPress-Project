import type { Components, JSX } from "../types/components";

interface ScTextarea extends Components.ScTextarea, HTMLElement {}
export const ScTextarea: {
    prototype: ScTextarea;
    new (): ScTextarea;
};
/**
 * Used to define this component and all nested components recursively.
 */
export const defineCustomElement: () => void;
