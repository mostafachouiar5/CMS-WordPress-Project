import { EventEmitter } from '../../../../stencil-public-runtime';
import { CancellationReason, ResponseError, Subscription, SubscriptionProtocol } from '../../../../types';
export declare class ScCancelDiscount {
    subscription: Subscription;
    reason: CancellationReason;
    comment: string;
    protocol: SubscriptionProtocol;
    scCancel: EventEmitter<void>;
    scPreserved: EventEmitter<void>;
    loading: boolean;
    error: ResponseError;
    addDiscount(): Promise<void>;
    hasDiscount(): boolean;
    render(): any;
}
