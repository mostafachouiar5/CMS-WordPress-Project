import { OrderStatus } from '../../../types';
export declare class ScOrderStatusBadge {
    /** The tag's statux type. */
    status: OrderStatus;
    /** The tag's size. */
    size: 'small' | 'medium' | 'large';
    /** Draws a pill-style tag with rounded edges. */
    pill: boolean;
    /** Makes the tag clearable. */
    clearable: boolean;
    getType(): "success" | "warning" | "danger";
    getText(): string;
    render(): any;
}
