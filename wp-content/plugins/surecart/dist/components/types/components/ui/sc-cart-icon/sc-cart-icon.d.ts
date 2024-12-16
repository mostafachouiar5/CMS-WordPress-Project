/**
 * @part base - The elements base wrapper.
 * @part container - The container.
 * @part icon__base - The icon base wrapper.
 */
export declare class ScCartIcon {
    /** The icon to show. */
    icon: string;
    /** Count the number of items in the cart. */
    getItemsCount(): number;
    /** Toggle the cart in the ui. */
    toggleCart(): void;
    render(): any;
}
