import { EventEmitter } from '../../../stencil-public-runtime';
import { ScMenu } from '../menu/sc-menu';
/**
 * @part base - The elements base wrapper.
 * @part trigger - The trigger.
 * @part panel - The panel.
 */
export declare class ScDropdown {
    el: HTMLDivElement;
    private panel?;
    private trigger?;
    private positioner?;
    private positionerCleanup;
    clickEl?: HTMLElement;
    /** Is this disabled. */
    disabled: boolean;
    /** Indicates whether or not the dropdown is open. You can use this in lieu of the show/hide methods. */
    open?: boolean;
    /** The placement of the dropdown panel */
    position: 'top-left' | 'top-right' | 'bottom-left' | 'bottom-right';
    /** The placement of the dropdown. */
    placement: 'top' | 'top-start' | 'top-end' | 'bottom' | 'bottom-start' | 'bottom-end' | 'right' | 'right-start' | 'right-end' | 'left' | 'left-start' | 'left-end';
    /** The distance in pixels from which to offset the panel away from its trigger. */
    distance: number;
    /** The distance in pixels from which to offset the panel along its trigger. */
    skidding: number;
    /**
     * Enable this option to prevent the panel from being clipped when the component is placed inside a container with
     * `overflow: auto|scroll`.
     */
    hoist: boolean;
    /** Determines whether the dropdown should hide when a menu item is selected */
    closeOnSelect: boolean;
    /** Emitted when the dropdown opens. Calling `event.preventDefault()` will prevent it from being opened. */
    scShow: EventEmitter<void>;
    /** Emitted when the dropdown closes. Calling `event.preventDefault()` will prevent it from being closed. */
    scHide: EventEmitter<void>;
    isVisible: boolean;
    handleOpenChange(): void;
    handleOutsideClick(evt: any): void;
    startPositioner(): void;
    updatePositioner(): void;
    stopPositioner(): void;
    show(): void;
    hide(): void;
    handleClick(e: any): void;
    componentWillLoad(): void;
    getMenu(): ScMenu;
    getItems(): HTMLScMenuItemElement[];
    handleHide(): void;
    handleKeyDown(event: KeyboardEvent): void;
    render(): any;
}
