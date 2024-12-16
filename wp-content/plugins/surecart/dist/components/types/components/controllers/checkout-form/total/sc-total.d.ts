import { Checkout } from '../../../../types';
export declare class ScTotal {
    total: 'total' | 'subtotal' | 'amount_due';
    order: Checkout;
    order_key: {
        total: string;
        subtotal: string;
        amount_due: string;
    };
    render(): any;
}
