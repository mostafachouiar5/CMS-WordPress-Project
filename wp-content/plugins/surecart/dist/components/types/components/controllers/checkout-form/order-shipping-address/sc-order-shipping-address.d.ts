import { Address } from '../../../../types';
export declare class ScOrderShippingAddress {
    private input;
    /** Label for the field. */
    label: string;
    /** Is this required (defaults to false) */
    required: boolean;
    /** Show the   address */
    full: boolean;
    /** Show the name field. */
    showName: boolean;
    /** Show the placeholder fields. */
    namePlaceholder: string;
    countryPlaceholder: string;
    cityPlaceholder: string;
    line1Placeholder: string;
    line2Placeholder: string;
    postalCodePlaceholder: string;
    statePlaceholder: string;
    /** Default country for address */
    defaultCountry: string;
    /** Whether to require the name in the address */
    requireName: boolean;
    /** Placeholder values. */
    placeholders: Partial<Address>;
    /** Address to pass to the component */
    address: Partial<Address>;
    /** Names for the address */
    names: {
        name: string;
        country: string;
        city: string;
        line_1: string;
        line_2: string;
        postal_code: string;
        state: string;
    };
    updateAddressState(address: Partial<Address>): Promise<void>;
    reportValidity(): Promise<boolean>;
    prefillAddress(): void;
    componentWillLoad(): void;
    render(): any;
}
