import { SubscriptionProtocol } from '../../../../types';
/**
 * Replace the {{ name }} in a string with a new value
 */
export declare const replaceAmount: (string: any, replace: any, name?: string) => any;
/**
 * Replace the amount in a string with discount.
 */
export declare const replaceAmountFromString: (amountStr: any, protocol: any) => any;
/**
 *
 */
export declare const getCurrentBehaviourContent: (protocol: SubscriptionProtocol, hasDiscount: any) => {
    title: any;
    description: any;
    button: string;
    cancel_link: string;
};
