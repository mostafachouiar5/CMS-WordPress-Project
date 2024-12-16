import { EventEmitter } from '../../../stencil-public-runtime';
export declare class ScTaxIdInput {
    /** The input */
    private input;
    /** The country code. */
    country: string;
    /** Force show the field. */
    show: boolean;
    /** Type of tax id */
    type: string;
    /** Tax ID Number */
    number: string;
    /** The status */
    status: 'valid' | 'invalid' | 'unknown';
    /** Is this loading? */
    loading: boolean;
    /** Help text. */
    help: string;
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
    /** Tax ID Types which will be shown */
    taxIdTypes: string[];
    /** Whether tax input is required */
    required: boolean;
    /** Make a request to update the order. */
    scChange: EventEmitter<{
        number: string;
        number_type: string;
    }>;
    /** Make a request to update the order. */
    scInput: EventEmitter<Partial<{
        number: string;
        number_type: string;
    }>>;
    /** Change the Type */
    scInputType: EventEmitter<string>;
    /** Set the checkout state. */
    scSetState: EventEmitter<string>;
    reportValidity(): Promise<boolean>;
    onLabelChange(): void;
    componentWillLoad(): void;
    renderStatus(): any;
    filteredZones(): {};
    onTaxIdTypesChange(): void;
    getZoneLabel(): any;
    render(): any;
}
