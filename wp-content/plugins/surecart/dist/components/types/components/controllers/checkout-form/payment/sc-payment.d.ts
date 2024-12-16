/**
 * @part base - The elements base wrapper.
 * @part form-control - The form control wrapper.
 * @part label - The input label.
 * @part help-text - Help text that describes how to use the input.
 * @part test-badge__base - Test badge base.
 * @part test-badge__content - Test badge content.
 */
export declare class ScPayment {
    /** This element. */
    el: HTMLScPaymentElement;
    stripePaymentElement: boolean;
    /** Disabled processor types */
    disabledProcessorTypes: string[];
    secureNotice: string;
    /** The input's label. */
    label: string;
    /** Hide the test mode badge */
    hideTestModeBadge: boolean;
    componentWillLoad(): void;
    renderStripe(processor: any): any;
    renderPayPal(processor: any): any;
    renderMock(processor: any): any;
    renderPaystack(processor: any): any;
    render(): any;
}
