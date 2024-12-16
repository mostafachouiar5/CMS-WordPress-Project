/**
 * Internal dependencies.
 */
import { Checkout, LineItem, Product, Upsell } from "../../types";
interface Store {
    upsell: Upsell;
    product: Product;
    line_item: LineItem;
    amount_due: number;
    checkout_id: string;
    checkout: Checkout;
    form_id: number;
    busy: boolean;
    disabled: boolean;
    success_url: string;
    loading: 'loading' | 'busy' | 'idle' | 'complete' | 'redirecting';
    text: {
        success: {
            title: string;
            description: string;
            button: string;
        };
    };
}
declare const state: Store, onChange: import("@stencil/store/dist/types").OnChangeHandler<Store>, on: import("@stencil/store/dist/types").OnHandler<Store>, dispose: () => void, forceUpdate: (key: keyof Store) => any;
export default state;
export { state, onChange, on, dispose, forceUpdate };
