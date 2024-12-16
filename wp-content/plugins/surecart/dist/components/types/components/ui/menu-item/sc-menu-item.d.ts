export declare class ScMenuItem {
    el: HTMLScMenuItemElement;
    private menuItem;
    private hasFocus;
    /** Optional link to follow. */
    href: string;
    /** The target of the link. */
    target: string;
    /** Draws the item in a checked state. */
    checked: boolean;
    /** A unique value to store in the menu item. This can be used as a way to identify menu items when selected. */
    value: string;
    /** Draws the menu item in a disabled state. */
    disabled: boolean;
    /** Sets focus on the button. */
    setFocus(options?: FocusOptions): Promise<void>;
    /** Removes focus from the button. */
    setBlur(): Promise<void>;
    handleBlur(): void;
    handleFocus(): void;
    render(): any;
}
