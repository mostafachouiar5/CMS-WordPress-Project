export declare class ScFormatNumber {
    /** The number to format. */
    value: number;
    /** The locale to use when formatting the number. */
    locale: string;
    /** The formatting style to use. */
    type: 'currency' | 'decimal' | 'percent' | 'unit';
    /** Turns off grouping separators. */
    noGrouping: boolean;
    /** The currency to use when formatting. Must be an ISO 4217 currency code such as `USD` or `EUR`. */
    currency: string;
    /** How to display the currency. */
    currencyDisplay: 'symbol' | 'narrowSymbol' | 'code' | 'name';
    /** The minimum number of integer digits to use. Possible values are 1 - 21. */
    minimumIntegerDigits: number;
    /** The minimum number of fraction digits to use. Possible values are 0 - 20. */
    minimumFractionDigits: number;
    /** The maximum number of fraction digits to use. Possible values are 0 - 20. */
    maximumFractionDigits: number;
    /** The minimum number of significant digits to use. Possible values are 1 - 21. */
    minimumSignificantDigits: number;
    /** The maximum number of significant digits to use,. Possible values are 1 - 21. */
    maximumSignificantDigits: number;
    /** Should we convert */
    noConvert: boolean;
    /** The unit to use when formatting.  */
    unit: string;
    render(): string;
}
