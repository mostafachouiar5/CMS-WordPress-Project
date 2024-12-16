import { EventEmitter } from '../../../stencil-public-runtime';
import { Address } from '../../../types';
/**
 * @part base - The elements base wrapper.
 * @part input__base - The inputs base element.
 * @part select__base - The select boxes base element.
 * @part input - The html input element.
 * @part form-control - The form control wrapper.
 * @part label - The input label.
 * @part help-text - Help text that describes how to use the input.
 * @part trigger - The select box trigger.
 * @part panel - The select box panel.
 * @part caret - The select box caret.
 * @part search__base - The select search base.
 * @part search__input - The select search input.
 * @part search__form-control - The select search form control.
 * @part menu__base - The select menu base.
 * @part spinner__base  - The select spinner base.
 * @part empty - The select empty message.
 * @part block-ui - The block ui base component.
 * @part block-ui__content - The block ui content (spinner).
 */
export declare class ScAddress {
    el: HTMLScAddressElement;
    /** The address. */
    address: Partial<Address>;
    names: Partial<Address>;
    placeholders: Partial<Address>;
    /** Is this loading?  */
    loading: boolean;
    /** Is this disabled? */
    disabled: boolean;
    /** The label for the field. */
    label: string;
    /** Should we show name field? */
    showName: boolean;
    /** Should we show name field? */
    showLine2: boolean;
    /** Is this required? */
    required: boolean;
    /** Is the name required */
    requireName: boolean;
    /** Should we show the city field? */
    showCity: boolean;
    /** Should we show the postal field? */
    showPostal: boolean;
    /** Holds the regions for a given country. */
    regions: Array<{
        value: string;
        label: string;
    }>;
    /** Holds our country choices. */
    countryChoices: Array<{
        value: string;
        label: string;
    }>;
    /** Address change event. */
    scChangeAddress: EventEmitter<Partial<Address>>;
    /** Address change event. */
    scInputAddress: EventEmitter<Partial<Address>>;
    /** When the state changes, we want to update city and postal fields. */
    handleAddressChange(): void;
    handleNameChange(): void;
    decodeHtmlEntities(html: string): string;
    updateAddress(address: Partial<Address>): void;
    handleAddressInput(address: Partial<Address>): void;
    clearAddress(): void;
    /** Set the regions based on the country. */
    setRegions(): void;
    componentWillLoad(): void;
    reportValidity(): Promise<boolean>;
    render(): any;
}
