import type { Components, JSX } from "../types/components";

interface ScDonationChoices extends Components.ScDonationChoices, HTMLElement {}
export const ScDonationChoices: {
    prototype: ScDonationChoices;
    new (): ScDonationChoices;
};
/**
 * Used to define this component and all nested components recursively.
 */
export const defineCustomElement: () => void;
