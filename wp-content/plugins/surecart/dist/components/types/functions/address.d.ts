import { Address } from '../types';
export declare const STATE_INCLUDED_COUNTRIES: string[];
export declare const POSTAL_CODE_EXCLUDED_COUNTRIES: string[];
export declare const CITY_EXCLUDED_COUNTRIES: string[];
export declare const hasPostal: (countryCode: string) => boolean;
export declare const hasCity: (countryCode: string) => boolean;
export declare const hasState: (countryCode: string) => boolean;
export declare const hasCompleteAddress: (args: any) => any;
export declare const hasCorrectState: (country: any, state: any) => any;
export declare const hasRequiredFields: ({ city, country, line_1, postal_code, state }: {
    city: any;
    country: any;
    line_1: any;
    postal_code: any;
    state: any;
}) => boolean;
export declare const countryChoices: Array<{
    value: string;
    label: string;
}>;
export declare const isAddressComplete: (address: Partial<Address>) => string | boolean;
export declare const isAddressCompleteEnough: (address: Partial<Address>) => string | boolean;
