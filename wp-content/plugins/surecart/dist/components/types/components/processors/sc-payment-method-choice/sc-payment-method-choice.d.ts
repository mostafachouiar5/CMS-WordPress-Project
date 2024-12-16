export declare class ScPaymentMethodChoice {
    el: HTMLScPaymentMethodChoiceElement;
    /** The method id */
    methodId: string;
    /** The processor ID */
    processorId: string;
    /** Is this a manual processor */
    isManual: boolean;
    /** Should we show this in a card? */
    card: boolean;
    isSelected(): boolean;
    getAllOptions(): HTMLScPaymentMethodChoiceElement[];
    getSiblingItems(): HTMLScPaymentMethodChoiceElement[];
    hasOthers(): boolean;
    render(): any;
}
