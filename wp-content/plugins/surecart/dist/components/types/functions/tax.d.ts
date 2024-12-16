import { TaxZones } from '../types';
export declare const zones: TaxZones;
export declare const getType: (key: any) => "ca_gst" | "au_abn" | "gb_vat" | "eu_vat";
export declare const formatTaxDisplay: (taxLabel: string) => string;
