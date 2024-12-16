/**
 * @part base - The elements base wrapper.
 */
export declare class ScCard {
    el: HTMLScCardElement;
    /** Eliminate the divider */
    noDivider: boolean;
    /** Is this card borderless. */
    borderless: boolean;
    /** Remove padding */
    noPadding: boolean;
    /** A link for the card. */
    href: string;
    /** Is this card loading. */
    loading: boolean;
    /** Does this have a title slot? */
    hasTitleSlot: boolean;
    componentWillLoad(): void;
    handleSlotChange(): void;
    render(): any;
}
