import { EventEmitter } from '../../../stencil-public-runtime';
export declare class ScDialog {
    el: HTMLElement;
    private dialog;
    private panel;
    private overlay;
    private originalTrigger;
    /** Indicates whether or not the dialog is open. You can use this in lieu of the show/hide methods. */
    open: boolean;
    /**
     * The dialog's label as displayed in the header. You should always include a relevant label even when using
     * `no-header`, as it is required for proper accessibility.
     */
    label: string;
    /**
     * Disables the header. This will also remove the default close button, so please ensure you provide an easy,
     * accessible way for users to dismiss the dialog.
     */
    noHeader: boolean;
    /** Does this have a footer */
    hasFooter: boolean;
    /** Request close event */
    scRequestClose: EventEmitter<'close-button' | 'keyboard' | 'overlay'>;
    scShow: EventEmitter<void>;
    scAfterShow: EventEmitter<void>;
    scHide: EventEmitter<void>;
    scAfterHide: EventEmitter<void>;
    scInitialFocus: EventEmitter<void>;
    /** Shows the dialog. */
    show(): Promise<any>;
    /** Hides the dialog */
    hide(): Promise<any>;
    private requestClose;
    handleKeyDown(event: KeyboardEvent): void;
    handleOpenChange(): Promise<void>;
    componentDidLoad(): void;
    disconnectedCallback(): void;
    render(): any;
}
