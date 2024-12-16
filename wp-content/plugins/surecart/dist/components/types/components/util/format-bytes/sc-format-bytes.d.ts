export declare class ScFormatBytes {
    /** The locale to use when formatting the number. */
    locale: string;
    /** The number to format in bytes. */
    value: number;
    /** The unit to display. */
    unit: 'byte' | 'bit';
    /** Determines how to display the result, e.g. "100 bytes", "100 b", or "100b". */
    display: 'long' | 'short' | 'narrow';
    render(): string;
}
