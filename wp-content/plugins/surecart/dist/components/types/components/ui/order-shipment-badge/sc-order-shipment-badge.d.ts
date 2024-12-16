import { OrderShipmentStatus } from '../../../types';
export declare class ScOrderShipmentBadge {
    /** The tag's statux type. */
    status: OrderShipmentStatus;
    /** The tag's size. */
    size: 'small' | 'medium' | 'large';
    /** Draws a pill-style tag with rounded edges. */
    pill: boolean;
    /** Makes the tag clearable. */
    clearable: boolean;
    render(): any;
}
