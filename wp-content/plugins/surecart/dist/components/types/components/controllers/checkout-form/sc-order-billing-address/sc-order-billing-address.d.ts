import { Address } from '../../../../types';
import { ScCheckboxCustomEvent } from "../../../../components";
export declare class ScOrderBillingAddress {
    /** The input */
    private input;
    /** Label for the field */
    label: string;
    /** Show the name field */
    showName: boolean;
    /** Name placeholder */
    namePlaceholder: string;
    /** Country placeholder */
    countryPlaceholder: string;
    /** City placeholder */
    cityPlaceholder: string;
    /** Address placeholder */
    line1Placeholder: string;
    /** Address Line 2 placeholder */
    line2Placeholder: string;
    /** Postal Code placeholder */
    postalCodePlaceholder: string;
    /** State placeholder */
    statePlaceholder: string;
    /** Default country for address */
    defaultCountry: string;
    /** Toggle label */
    toggleLabel: string;
    /** Address to pass to the component */
    address: Partial<Address>;
    reportValidity(): Promise<boolean>;
    prefillAddress(): void;
    componentWillLoad(): void;
    updateAddressState(address: Partial<Address>): Promise<void>;
    onToggleBillingMatchesShipping(e: ScCheckboxCustomEvent<void>): Promise<void>;
    shippingAddressFieldExists(): boolean;
    render(): any;
}
