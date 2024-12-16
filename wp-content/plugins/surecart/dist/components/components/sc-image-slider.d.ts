import type { Components, JSX } from "../types/components";

interface ScImageSlider extends Components.ScImageSlider, HTMLElement {}
export const ScImageSlider: {
    prototype: ScImageSlider;
    new (): ScImageSlider;
};
/**
 * Used to define this component and all nested components recursively.
 */
export const defineCustomElement: () => void;
