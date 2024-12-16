import type { Components, JSX } from "../types/components";

interface ScConsumer extends Components.ScConsumer, HTMLElement {}
export const ScConsumer: {
    prototype: ScConsumer;
    new (): ScConsumer;
};
/**
 * Used to define this component and all nested components recursively.
 */
export const defineCustomElement: () => void;
