import { EventEmitter } from '../../../stencil-public-runtime';
export declare class ScToggle {
    el: HTMLScToggleElement;
    private header;
    private body;
    /** Indicates whether or not the details is open. You can use this in lieu of the show/hide methods. */
    open: boolean;
    /** The summary to show in the details header. If you need to display HTML, use the `summary` slot instead. */
    summary: string;
    /** Disables the details so it can't be toggled. */
    disabled: boolean;
    /** Is this a borderless toggle? */
    borderless: boolean;
    /** Is this a shady */
    shady: boolean;
    /** Should we show a radio control?  */
    showControl: boolean;
    /** Should we show the arrow icon? */
    showIcon: boolean;
    /** Are these collapsible? */
    collapsible: boolean;
    /** Show the toggle */
    scShow: EventEmitter<void>;
    /** Show the toggle */
    scHide: EventEmitter<void>;
    componentDidLoad(): void;
    /** Shows the details. */
    show(): Promise<any>;
    /** Hides the details */
    hide(): Promise<any>;
    handleSummaryClick(): void;
    handleSummaryKeyDown(event: KeyboardEvent): void;
    handleOpenChange(): Promise<void>;
    render(): any;
}
