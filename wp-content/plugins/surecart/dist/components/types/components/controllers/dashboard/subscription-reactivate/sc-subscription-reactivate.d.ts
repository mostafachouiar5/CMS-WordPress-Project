import { EventEmitter } from '../../../../stencil-public-runtime';
import { Period, Subscription } from "../../../../types";
export declare class ScSubscriptionReactivate {
    /** Whether it is open */
    open: boolean;
    /** The subscription to reactivate */
    subscription: Subscription;
    /** Reactivate modal closed */
    scRequestClose: EventEmitter<'close-button' | 'keyboard' | 'overlay'>;
    /** Refresh subscriptions */
    scRefresh: EventEmitter<void>;
    busy: boolean;
    error: string;
    upcomingPeriod: Period;
    loading: boolean;
    openChanged(): void;
    fetchUpcoming(): Promise<void>;
    reactivateSubscription(): Promise<void>;
    renderLoading(): any;
    render(): any;
}
