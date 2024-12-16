import { Fulfillment } from "../../../../types";
export declare class ScFulfillments {
    el: HTMLScFulfillmentsElement;
    orderId: string;
    heading: string;
    /** Holds fulfillments. */
    fulfillments: Fulfillment[];
    /** Loading state */
    loading: boolean;
    busy: boolean;
    /** Error message */
    error: string;
    componentDidLoad(): void;
    fetch(): Promise<void>;
    renderLoading(): any;
    render(): any;
}
