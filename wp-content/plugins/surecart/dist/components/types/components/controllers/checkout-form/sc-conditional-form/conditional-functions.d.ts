import { Checkout, Rule, RuleGroup } from '../../../../types';
/**
 * Check if any of the rule groups is passed or not.
 *
 * @param {array} groups Rule groups.
 * @param {object} props Data.
 * @returns {boolean}
 */
export declare const hasAnyRuleGroupPassed: (groups: RuleGroup[], props: {
    checkout: Checkout;
    processor: string;
}) => boolean;
/**
 * CHeck if all rules are passed or not.
 *
 * @param {array} rules Rules.
 * @param {object} props Data.
 * @returns {boolean}
 */
export declare const hasRulesPassed: (rules: Rule[], { checkout, processor }: {
    checkout: any;
    processor: any;
}) => boolean;
/**
 * Get array of products from checkout.
 *
 * @param {object} checkout CHeckout data.
 * @returns {array}
 */
export declare const getCartProductIds: (checkout: Checkout) => string[];
/**
 * Get array of coupons from checkout.
 *
 * @param {object} checkout CHeckout data.
 * @returns {array}
 */
export declare const getCartCouponIds: (checkout: Checkout) => string[];
/**
 * Compare object values.
 *
 * @param {array} cart_values order values.
 * @param {array} rule_values rules values.
 * @param {string} operator rule operator.
 * @returns {boolean}
 */
export declare const compareObjectValues: (cart_values: string[], rule_values: string[], operator: 'all' | 'any' | 'none' | 'exist' | 'not_exist') => boolean;
/**
 * Compare string values.
 *
 * @param string number1 The actual number from cart/order.
 * @param array  number2 Rule values.
 * @param string operator Rule operator.
 * @returns {boolean}
 */
export declare const compareNumberValues: (number1: number, number2: number, operator: string) => boolean;
