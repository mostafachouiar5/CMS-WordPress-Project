import { EventEmitter } from '../../../../stencil-public-runtime';
import { CancellationReason, Subscription, SubscriptionProtocol } from '../../../../types';
export declare class ScCancelDialog {
    open: boolean;
    protocol: SubscriptionProtocol;
    subscription: Subscription;
    reasons: CancellationReason[];
    reason: CancellationReason;
    step: 'cancel' | 'survey' | 'discount' | 'discount-complete';
    comment: string;
    scRequestClose: EventEmitter<'close-button' | 'keyboard' | 'overlay'>;
    scRefresh: EventEmitter<void>;
    close(): void;
    reset(): void;
    trackAttempt(): Promise<void>;
    componentWillLoad(): void;
    render(): any;
}
