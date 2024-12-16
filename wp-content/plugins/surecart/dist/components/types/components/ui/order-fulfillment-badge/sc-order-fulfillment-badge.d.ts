import { OrderFulFillmentStatus } from '../../../types';
export declare class ScOrderFulFillmentBadge {
    /** The tag's statux type. */
    status: OrderFulFillmentStatus;
    /** The tag's size. */
    size: 'small' | 'medium' | 'large';
    /** Draws a pill-style tag with rounded edges. */
    pill: boolean;
    /** Makes the tag clearable. */
    clearable: boolean;
    render(): any;
}
