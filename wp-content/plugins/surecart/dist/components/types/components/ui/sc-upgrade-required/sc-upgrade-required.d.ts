export declare class ScUpgradeRequired {
    /** The tag's size. */
    size: 'small' | 'medium' | 'large';
    /** Is this required? */
    required: boolean;
    /** Whether to render upgrade modal by default */
    open: boolean;
    render(): any;
}
