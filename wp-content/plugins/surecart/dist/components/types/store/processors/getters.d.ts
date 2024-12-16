/**
 * Gets a sorted array of available processors based on
 * checkout mode, recurring requirements, and if mollie is enabled.
 */
export declare const availableProcessors: () => any;
/**
 * Gets the processor by type
 *
 * @param {string} type The processor type.
 *
 * @returns {Object | null} The processor data.
 */
export declare const getProcessorByType: (type: string) => any;
/**
 * Gets an available processor type.
 */
export declare const getAvailableProcessor: (type: string) => any;
/**
 * Check if there is any available credit card processor except the given processor type.
 */
export declare const hasOtherAvailableCreditCardProcessor: (type: string) => any;
/**
 * Get a sorted array of manual payment methods
 * based on recurring requirements.
 */
export declare const availableManualPaymentMethods: () => any;
/**
 * Get a sorted array of mollie payment method types.
 */
export declare const availableMethodTypes: () => any;
/**
 * Get a combined available processor choices (processors + manual payment methods)
 */
export declare const availableProcessorChoices: () => any[];
/**
 * Do we have multiple processors.
 */
export declare const hasMultipleProcessorChoices: () => boolean;
/**
 * Get a combined available payment methods (method types + manual payment methods)
 */
export declare const availableMethodChoices: () => any[];
/**
 * Do we have multiple payment methods.
 */
export declare const hasMultipleMethodChoices: () => boolean;
