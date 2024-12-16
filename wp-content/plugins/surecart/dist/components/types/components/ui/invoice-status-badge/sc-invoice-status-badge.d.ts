/**
 * Internal dependencies.
 */
import { InvoiceStatus } from '../../../types';
export declare class ScInvoiceStatusBadge {
    /** The tag's statux type. */
    status: InvoiceStatus;
    /** The tag's size. */
    size: 'small' | 'medium' | 'large';
    /** Draws a pill-style tag with rounded edges. */
    pill: boolean;
    /** Makes the tag clearable. */
    clearable: boolean;
    getType(): "default" | "info" | "success";
    getText(): string;
    render(): any;
}
