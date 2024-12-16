import { EventEmitter } from '../../../stencil-public-runtime';
export declare class ScMenu {
    el: HTMLElement;
    scSelect: EventEmitter<{
        item: HTMLScMenuItemElement;
    }>;
    private items;
    ariaLabel: string;
    /** TODO: Click test */
    handleClick(event: MouseEvent): void;
    /** TODO: Keydown Test */
    handleKeyDown(event: KeyboardEvent): void;
    /** Get the active item */
    getCurrentItem(): HTMLScMenuItemElement;
    /**
     * @internal Sets the current menu item to the specified element. This sets `tabindex="0"` on the target element and
     * `tabindex="-1"` to all other items. This method must be called prior to setting focus on a menu item.
     */
    setCurrentItem(item: HTMLScMenuItemElement): Promise<void>;
    /** Sync slotted items with internal state */
    syncItems(): void;
    /** Handle items change in slot */
    handleSlotChange(): void;
    render(): any;
}
