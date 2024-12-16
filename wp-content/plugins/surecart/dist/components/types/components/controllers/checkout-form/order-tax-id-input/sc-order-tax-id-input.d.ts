export declare class ScOrderTaxIdInput {
    /** The tax id input */
    private input;
    /** Force show the field. */
    show: boolean;
    /** Other zones label */
    otherLabel: string;
    /** GST zone label */
    caGstLabel: string;
    /** AU zone label */
    auAbnLabel: string;
    /** UK zone label */
    gbVatLabel: string;
    /** EU zone label */
    euVatLabel: string;
    /** Help text */
    helpText: string;
    /** Tax ID Types which will be shown Eg: '["eu_vat", "gb_vat"]' */
    taxIdTypes: string | string[];
    /** Tax ID Types data as array */
    taxIdTypesData: string[];
    handleTaxIdTypesChange(): void;
    reportValidity(): Promise<boolean>;
    getStatus(): "unknown" | "invalid" | "valid";
    updateOrder(tax_identifier: {
        number: string;
        number_type: string;
    }): Promise<void>;
    componentWillLoad(): void;
    required(): boolean;
    render(): any;
}
