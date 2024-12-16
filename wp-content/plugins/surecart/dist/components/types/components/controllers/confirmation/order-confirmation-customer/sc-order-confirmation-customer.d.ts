import { Customer, Checkout } from '../../../../types';
export declare class ScOrderConfirmationCustomer {
    /** The Order */
    order: Checkout;
    /** The heading */
    heading: string;
    /** The customer */
    customer: Customer;
    /** Error message. */
    error: string;
    /** Is this loading? */
    loading: boolean;
    render(): any;
}
