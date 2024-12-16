import { Subscription, SubscriptionStatus } from '../../../types';
export declare class ScSubscriptionStatusBadge {
    /** Subscription status */
    status: SubscriptionStatus;
    /** The tag's status type. */
    subscription: Subscription;
    /** The tag's size. */
    size: 'small' | 'medium' | 'large';
    /** Draws a pill-style tag with rounded edges. */
    pill: boolean;
    /** Makes the tag clearable. */
    clearable: boolean;
    getType(): "info" | "success" | "warning" | "danger";
    getText(): any;
    render(): any;
}
