import { FulfillmentStatus } from '../../../types';
export declare class ScOrderStatusBadge {
    /** The tag's statux type. */
    status: FulfillmentStatus;
    /** The tag's size. */
    size: 'small' | 'medium' | 'large';
    /** Draws a pill-style tag with rounded edges. */
    pill: boolean;
    /** Makes the tag clearable. */
    clearable: boolean;
    render(): any;
}
