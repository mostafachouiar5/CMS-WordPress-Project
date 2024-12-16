import type { Components, JSX } from "../types/components";

interface ScProductText extends Components.ScProductText, HTMLElement {}
export const ScProductText: {
    prototype: ScProductText;
    new (): ScProductText;
};
/**
 * Used to define this component and all nested components recursively.
 */
export const defineCustomElement: () => void;
