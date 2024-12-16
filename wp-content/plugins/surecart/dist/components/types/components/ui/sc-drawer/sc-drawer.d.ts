import { EventEmitter } from '../../../stencil-public-runtime';
export declare class ScDrawer {
    el: HTMLScDrawerElement;
    private drawer;
    private panel;
    private overlay;
    private originalTrigger;
    scInitialFocus: EventEmitter<void>;
    scRequestClose: EventEmitter<'close-button' | 'keyboard' | 'overlay' | 'method'>;
    scShow: EventEmitter<void>;
    scHide: EventEmitter<void>;
    scAfterShow: EventEmitter<void>;
    scAfterHide: EventEmitter<void>;
    /** Indicates whether or not the drawer is open. You can use this in lieu of the show/hide methods. */
    open: boolean;
    /**
     * The drawer's label as displayed in the header. You should always include a relevant label even when using
     * `no-header`, as it is required for proper accessibility.
     */
    label: string;
    /** The direction from which the drawer will open. */
    placement: 'top' | 'end' | 'bottom' | 'start';
    /**
     * By default, the drawer slides out of its containing block (usually the viewport). To make the drawer slide out of
     * its parent element, set this prop and add `position: relative` to the parent.
     */
    contained: boolean;
    /**
     * Removes the header. This will also remove the default close button, so please ensure you provide an easy,
     * accessible way for users to dismiss the drawer.
     */
    noHeader: boolean;
    /** Sticky drawer header */
    stickyHeader: boolean;
    componentDidLoad(): void;
    disconnectedCallback(): void;
    lockBodyScrolling(): void;
    unLockBodyScrolling(): void;
    /** Shows the drawer. */
    show(): Promise<any>;
    /** Hides the drawer */
    hide(): Promise<any>;
    requestClose(source?: 'close-button' | 'keyboard' | 'overlay' | 'method'): Promise<void>;
    handleKeyDown(event: KeyboardEvent): void;
    handleOpenChange(): Promise<void>;
    render(): any;
}
