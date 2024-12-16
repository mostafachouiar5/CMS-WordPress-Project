/**
 * @part base - The elements base wrapper.
 * @part separator - The separator.
 */
export declare class ScBreadcrumbs {
    el: HTMLElement;
    /**
     * The label to use for the breadcrumb control. This will not be shown, but it will be announced by screen readers and
     * other assistive devices.
     */
    label: string;
    private getSeparator;
    handleSlotChange(): void;
    render(): any;
}
