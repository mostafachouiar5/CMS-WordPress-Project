/**
 * @part base - The elements base wrapper.
 * @part label - The label.
 * @part suffix - The suffix item.
 * @part prefix - The prefix item.
 * @part separator - The separator.
 */
export declare class ScBreadcrumb {
    el: HTMLScBreadcrumbElement;
    /**
     * Optional URL to direct the user to when the breadcrumb item is activated. When set, a link will be rendered
     * internally. When unset, a button will be rendered instead.
     */
    href?: string;
    /** Tells the browser where to open the link. Only used when `href` is set. */
    target?: '_blank' | '_parent' | '_self' | '_top';
    /** The `rel` attribute to use on the link. Only used when `href` is set. */
    rel: string;
    hasPrefix: boolean;
    hasSuffix: boolean;
    handleSlotChange(): void;
    render(): any;
}
