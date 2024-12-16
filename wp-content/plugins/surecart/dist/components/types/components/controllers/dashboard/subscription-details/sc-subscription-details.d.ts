import { Price, Subscription } from '../../../../types';
export declare class ScSubscriptionDetails {
    subscription: Subscription;
    pendingPrice: Price;
    hideRenewalText: boolean;
    activationsModal: boolean;
    loading: boolean;
    hasPendingUpdate: boolean;
    renderName(): string;
    handleSubscriptionChange(): Promise<void>;
    componentWillLoad(): void;
    fetchPrice(price_id: string): Promise<Price>;
    renderRenewalText(): any;
    getActivations(): import("../../../../types").Activation[];
    renderActivations(): any;
    showWarning(): boolean;
    render(): any;
}
