import { Customer } from '../../../../types';
export declare class ScDashboardCustomerDetails {
    el: HTMLScCustomerDetailsElement;
    customerId: string;
    heading: string;
    customer: Customer;
    loading: boolean;
    error: string;
    componentWillLoad(): void;
    fetch(): Promise<void>;
    render(): any;
}
