import { EventEmitter } from '../../../stencil-public-runtime';
/**
 * @part base - The elements base wrapper.
 * @part icon - The alert icon.
 * @part text - The alert text.
 * @part title - The alert title.
 * @part message - The alert message.
 * @part close - The close icon.
 */
export declare class ScAlert {
    el: HTMLScAlertElement;
    /** Indicates whether or not the alert is open. You can use this in lieu of the show/hide methods. */
    open: boolean;
    /** The title. */
    title: string;
    /** Makes the alert closable. */
    closable: boolean;
    /** The type of alert. */
    type: 'primary' | 'success' | 'info' | 'warning' | 'danger';
    /**
     * The length of time, in milliseconds, the alert will show before closing itself. If the user interacts with
     * the alert before it closes (e.g. moves the mouse over it), the timer will restart. Defaults to `Infinity`.
     */
    duration: number;
    /** Scroll into view. */
    scrollOnOpen: boolean;
    /** Scroll margin */
    scrollMargin: string;
    /** No icon */
    noIcon: boolean;
    autoHideTimeout: any;
    /** When alert is hidden */
    scHide: EventEmitter<void>;
    /** When alert is shown */
    scShow: EventEmitter<void>;
    /** Shows the alert. */
    show(): Promise<void>;
    /** Hides the alert */
    hide(): Promise<void>;
    restartAutoHide(): void;
    handleMouseMove(): void;
    handleCloseClick(): void;
    /** Emit event when showing or hiding changes */
    handleOpenChange(): void;
    componentDidLoad(): void;
    iconName(): "info" | "alert-circle" | "alert-triangle" | "check-circle";
    icon(): any;
    render(): any;
}
