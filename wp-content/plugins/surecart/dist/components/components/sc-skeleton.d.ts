import type { Components, JSX } from "../types/components";

interface ScSkeleton extends Components.ScSkeleton, HTMLElement {}
export const ScSkeleton: {
    prototype: ScSkeleton;
    new (): ScSkeleton;
};
/**
 * Used to define this component and all nested components recursively.
 */
export const defineCustomElement: () => void;
