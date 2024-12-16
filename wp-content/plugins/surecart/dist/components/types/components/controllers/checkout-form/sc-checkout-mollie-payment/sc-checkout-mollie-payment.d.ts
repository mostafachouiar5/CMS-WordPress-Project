import { PaymentMethodType, ResponseError } from '../../../../types';
export declare class ScCheckoutMolliePayment {
    processorId: string;
    method: string;
    error: ResponseError;
    methods: PaymentMethodType[];
    componentWillLoad(): void;
    fetchMethods(): Promise<void>;
    renderLoading(): any;
    render(): any;
}
