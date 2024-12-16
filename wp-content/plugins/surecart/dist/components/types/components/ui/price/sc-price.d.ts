/**
 * Internal dependencies.
 */
export declare class ScProductPrice {
    /** The currency. */
    currency: string;
    /** The amount */
    amount: number;
    /** The scratch amount */
    scratchAmount: number;
    /** The sale text */
    saleText: string;
    /** Is the product ad_hoc? */
    adHoc: boolean;
    /** The recurring period count */
    recurringPeriodCount: number;
    /** The recurring interval count */
    recurringIntervalCount: number;
    /** The recurring interval */
    recurringInterval: 'week' | 'month' | 'year' | 'never';
    /** The setup fee amount */
    setupFeeAmount: number;
    /** The trial duration days */
    trialDurationDays: number;
    /** The setup fee name */
    setupFeeName: string;
    render(): any;
}
