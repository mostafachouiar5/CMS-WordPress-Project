import { PaymentMethod } from '../../../../types';
export declare class ScPaymentMethodsList {
    el: HTMLScPaymentMethodsListElement;
    /** Query to fetch paymentMethods */
    query: object;
    /** The heading */
    heading: string;
    /** Is this a customer */
    isCustomer: boolean;
    /** Whether default payment method can be detached */
    canDetachDefaultPaymentMethod: boolean;
    /** Loaded payment methods */
    paymentMethods: Array<PaymentMethod>;
    /** Loading state */
    loading: boolean;
    busy: boolean;
    /** Error message */
    error: string;
    /** Does this have a title slot */
    hasTitleSlot: boolean;
    /** Stores the currently selected payment method for editing */
    editPaymentMethod: PaymentMethod | false;
    /** Stores the currently selected payment method for editing */
    deletePaymentMethod: PaymentMethod | false;
    /** Whether to cascade default payment method */
    cascadeDefaultPaymentMethod: boolean;
    /** Only fetch if visible */
    componentWillLoad(): void;
    handleSlotChange(): void;
    /**
     * Delete the payment method.
     */
    deleteMethod(): Promise<void>;
    /**
     * Set the default payment method.
     */
    setDefault(): Promise<void>;
    /** Get all paymentMethods */
    getPaymentMethods(): Promise<void>;
    renderLoading(): any;
    renderEmpty(): any;
    renderPaymentMethodActions(paymentMethod: PaymentMethod): any;
    renderList(): any[];
    renderContent(): any;
    handleEditPaymentMethodChange(): void;
    render(): any;
}
