import { Subscription, SubscriptionProtocol } from '../../../../types';
export declare class ScSubscription {
    el: HTMLScSubscriptionsListElement;
    /** The subscription ID */
    subscriptionId: string;
    /** Whether to show the cancel button */
    showCancel: boolean;
    /** Heading to display */
    heading: string;
    /** Query to pass to the API */
    query: object;
    /** The subscription protocol */
    protocol: SubscriptionProtocol;
    /** The subscription */
    subscription: Subscription;
    /** Update the payment method url */
    updatePaymentMethodUrl: string;
    /** Loading state */
    loading: boolean;
    /** Cancel modal */
    cancelModal: boolean;
    /** Resubscribe modal */
    resubscribeModal: boolean;
    /**  Busy state */
    busy: boolean;
    /** Error message */
    error: string;
    componentWillLoad(): void;
    cancelPendingUpdate(): Promise<void>;
    renewSubscription(): Promise<void>;
    /** Get all subscriptions */
    getSubscription(): Promise<void>;
    renderName(subscription: Subscription): string;
    renderRenewalText(subscription: any): any;
    renderEmpty(): any;
    renderLoading(): any;
    renderContent(): any;
    render(): any;
}
