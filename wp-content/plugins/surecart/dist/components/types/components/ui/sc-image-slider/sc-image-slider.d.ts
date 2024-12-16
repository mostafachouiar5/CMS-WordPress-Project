export declare class ScImageSlider {
    private swiperThumbsRef?;
    private swiperContainerRef?;
    private previous;
    private next;
    private swiper;
    private thumbsSwiper;
    /** Accept a string or an array of objects */
    images: string | {
        src: string;
        alt: string;
        srcset: any;
        width: number;
        height: number;
        sizes: string;
        title: string;
    }[];
    thumbnails: string | {
        src: string;
        alt: string;
        srcset: any;
        width: number;
        height: number;
        sizes: string;
        title: string;
    }[];
    hasThumbnails: boolean;
    thumbnailsPerPage: number;
    autoHeight: boolean;
    /** Current Slide Index */
    currentSliderIndex: number;
    imagesData: {
        src: string;
        alt: string;
        srcset: any;
        width: number;
        height: number;
        sizes: string;
        title: string;
    }[];
    thumbnailsData: {
        src: string;
        alt: string;
        srcset: any;
        width: number;
        height: number;
        sizes: string;
        title: string;
    }[];
    handleThumbPaginate(): void;
    parseImages(newValue: string | {
        src: string;
        alt: string;
    }[]): void;
    parseThumnails(newValue: string | {
        src: string;
        alt: string;
    }[]): void;
    componentWillLoad(): void;
    componentDidUpdate(): void;
    componentDidLoad(): void;
    disconnectedCallback(): void;
    render(): any;
}
