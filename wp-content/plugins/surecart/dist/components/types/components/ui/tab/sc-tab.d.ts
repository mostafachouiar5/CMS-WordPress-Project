import { EventEmitter } from '../../../stencil-public-runtime';
export declare class ScTab {
    el: HTMLElement;
    private tab;
    private componentId;
    /** The name of the tab panel the tab will control. The panel must be located in the same tab group. */
    panel: string;
    href: string;
    /** Draws the tab in an active state. */
    active: boolean;
    /** Draws the tab in a disabled state. */
    disabled: boolean;
    count: string;
    private hasPrefix;
    private hasSuffix;
    /** Close event */
    scClose: EventEmitter<void>;
    /** Sets focus to the tab. */
    triggerFocus(options?: FocusOptions): Promise<void>;
    /** Removes focus from the tab. */
    triggerBlur(): Promise<void>;
    handleSlotChange(): void;
    render(): any;
}
