/**
 * @part base - The elements base wrapper.
 * @part count - The icon base wrapper.
 */
export declare class ScCartButton {
    private link;
    /** The cart element. */
    el: HTMLScCartButtonElement;
    /** Is this open or closed? */
    open: boolean;
    /** The order count */
    count: number;
    /** The form id to use for the cart. */
    formId: string;
    /** Are we in test or live mode. */
    mode: 'test' | 'live';
    /** Whether the cart icon is always shown when the cart is empty */
    cartMenuAlwaysShown: boolean;
    /** Whether the cart count will be shown or not when the cart is empty */
    showEmptyCount: boolean;
    /** Count the number of items in the cart. */
    getItemsCount(): number;
    componentDidLoad(): void;
    handleParentLinkDisplay(): void;
    render(): any;
}
