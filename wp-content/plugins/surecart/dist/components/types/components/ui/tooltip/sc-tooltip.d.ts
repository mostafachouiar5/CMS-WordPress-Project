/**
 * @part base - The elements base wrapper.
 * @part text - The tooltip text.
 */
export declare class ScTooltip {
    el: HTMLScTooltipElement;
    private tooltip;
    /** Open or not */
    open: boolean;
    /** Tooltip fixed width */
    width: string;
    /** Tooltip text */
    text: string;
    /** Freeze open or closed. */
    freeze: boolean;
    /** The tooltip's padding. */
    padding: number;
    /** The tooltip's type. */
    type: 'primary' | 'success' | 'info' | 'warning' | 'danger' | 'text';
    top: number;
    left: number;
    componentDidLoad(): void;
    handleWindowScroll(): void;
    handleOpenChange(): void;
    handleBlur(): void;
    handleClick(): void;
    handleFocus(): void;
    handleMouseOver(): void;
    handleMouseOut(): void;
    render(): any;
}
