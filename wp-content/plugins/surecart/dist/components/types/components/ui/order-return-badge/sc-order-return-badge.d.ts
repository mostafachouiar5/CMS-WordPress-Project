/**
 * Internal dependencies.
 */
import { ReturnRequestStatus } from '../../../types';
export declare class ScOrderReturnBadge {
    /** The tag's statux type. */
    status: ReturnRequestStatus;
    /** The tag's size. */
    size: 'small' | 'medium' | 'large';
    /** Draws a pill-style tag with rounded edges. */
    pill: boolean;
    /** Makes the tag clearable. */
    clearable: boolean;
    render(): any;
}
