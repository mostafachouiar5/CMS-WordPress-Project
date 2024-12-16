export declare class ScFormatDate {
    /** The locale to use when formatting the date/time. */
    locale: string;
    /** The date/time to format. If not set, the current date and time will be used. */
    date: Date | string | number;
    /** The format for displaying the weekday. */
    weekday: 'narrow' | 'short' | 'long';
    /** The format for displaying the era. */
    era: 'narrow' | 'short' | 'long';
    /** The format for displaying the year. */
    year: 'numeric' | '2-digit';
    /** The format for displaying the month. */
    month: 'numeric' | '2-digit' | 'narrow' | 'short' | 'long';
    /** The format for displaying the day. */
    day: 'numeric' | '2-digit';
    /** The format for displaying the hour. */
    hour: 'numeric' | '2-digit';
    /** The format for displaying the minute. */
    minute: 'numeric' | '2-digit';
    /** The format for displaying the second. */
    second: 'numeric' | '2-digit';
    /** The format for displaying the time. */
    timeZoneName: 'short' | 'long';
    /** The time zone to express the time in. */
    timeZone: string;
    /** When set, 24 hour time will always be used. */
    hourFormat: 'auto' | '12' | '24';
    type: 'timestamp' | 'date';
    render(): string;
}
