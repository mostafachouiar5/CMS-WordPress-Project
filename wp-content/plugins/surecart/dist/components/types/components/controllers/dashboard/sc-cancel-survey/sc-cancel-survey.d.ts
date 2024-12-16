import { EventEmitter } from '../../../../stencil-public-runtime';
import { CancellationReason, ResponseError, SubscriptionProtocol } from '../../../../types';
export declare class ScCancelSurvey {
    private textArea;
    protocol: SubscriptionProtocol;
    reasons: CancellationReason[];
    loading: boolean;
    selectedReason: CancellationReason;
    comment: string;
    error: ResponseError;
    scAbandon: EventEmitter<void>;
    scSubmitReason: EventEmitter<{
        reason: CancellationReason;
        comment: string;
    }>;
    componentWillLoad(): void;
    handleSelectedReasonChange(): void;
    fetchReasons(): Promise<void>;
    handleSubmit(e: any): Promise<void>;
    renderReasons(): any;
    render(): any;
}
