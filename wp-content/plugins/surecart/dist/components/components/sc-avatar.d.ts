import type { Components, JSX } from "../types/components";

interface ScAvatar extends Components.ScAvatar, HTMLElement {}
export const ScAvatar: {
    prototype: ScAvatar;
    new (): ScAvatar;
};
/**
 * Used to define this component and all nested components recursively.
 */
export const defineCustomElement: () => void;
