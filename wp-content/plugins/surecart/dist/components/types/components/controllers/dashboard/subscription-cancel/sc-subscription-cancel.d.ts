import { EventEmitter } from '../../../../stencil-public-runtime';
import { CancellationReason, SubscriptionProtocol } from '../../../../types';
import { Subscription } from '../../../../types';
export declare class ScSubscriptionCancel {
    heading: string;
    backUrl: string;
    successUrl: string;
    subscription: Subscription;
    protocol: SubscriptionProtocol;
    reason: CancellationReason;
    comment: string;
    loading: boolean;
    busy: boolean;
    error: string;
    scAbandon: EventEmitter<void>;
    scCancelled: EventEmitter<void>;
    cancelSubscription(): Promise<void>;
    renderContent(): any;
    renderLoading(): any;
    render(): any;
}
