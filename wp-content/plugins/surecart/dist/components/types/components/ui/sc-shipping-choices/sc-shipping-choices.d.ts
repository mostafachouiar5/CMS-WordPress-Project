/**
 * @part base - The elements base wrapper.
 * @part empty - The empty message.
 * @part block-ui - The block ui loader.
 * @part radio__base - The radio base wrapper.
 * @part radio__label - The radio label.
 * @part radio__control - The radio control wrapper.
 * @part radio__checked-icon - The radio checked icon.
 */
export declare class ScShippingChoices {
    /** The shipping section label */
    label: string;
    /** Whether to show the shipping choice description */
    showDescription: boolean;
    /** Maybe update the order. */
    updateCheckout(selectedShippingChoiceId: string): Promise<void>;
    render(): any;
}
