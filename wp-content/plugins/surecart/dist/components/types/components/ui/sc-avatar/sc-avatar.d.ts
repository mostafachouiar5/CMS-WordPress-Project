export declare class ScAvatar {
    private hasError;
    /** The image source to use for the avatar. */
    image: string;
    /** A label to use to describe the avatar to assistive devices. */
    label: string;
    /** Initials to use as a fallback when no image is available (1-2 characters max recommended). */
    initials: string;
    /** Indicates how the browser should load the image. */
    loading: 'eager' | 'lazy';
    /** The shape of the avatar. */
    shape: 'circle' | 'square' | 'rounded';
    handleImageChange(): void;
    render(): any;
}
