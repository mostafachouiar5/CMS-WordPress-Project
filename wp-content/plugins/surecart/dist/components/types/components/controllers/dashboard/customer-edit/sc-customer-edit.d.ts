import { Customer } from '../../../../types';
export declare class ScCustomerEdit {
    heading: string;
    customer: Customer;
    successUrl: string;
    loading: boolean;
    error: string;
    handleSubmit(e: any): Promise<void>;
    render(): any;
}
