/**
 * @slot image - Line item image
 * @slot title - Line item title.
 * @slot description - Line item description (below the title)
 * @slot currency - Used for the 3 character currency code.
 * @slot price - Price amount, including currency sign.
 * @slot price-description - Description for the price (i.e. monthly)
 *
 * @part base - The elements base wrapper.
 * @part image - The image wrapper.
 * @part text - The text.
 * @part title - The title.
 * @part description - Line item description (below the title)
 * @part currency - Used for the 3 character currency code.
 * @part price - Price amount, including currency sign.
 * @part price-text - The price text.
 * @part price-description - Description for the price (i.e. monthly)
 */
export declare class ScLineItem {
    hostElement: HTMLScLineItemElement;
    /** Price of the item */
    price: string;
    /** Currency symbol */
    currency: string;
    hasImageSlot: boolean;
    hasTitleSlot: boolean;
    hasDescriptionSlot: boolean;
    hasPriceSlot: boolean;
    hasPriceDescriptionSlot: boolean;
    hasCurrencySlot: boolean;
    componentWillLoad(): void;
    render(): any;
}
