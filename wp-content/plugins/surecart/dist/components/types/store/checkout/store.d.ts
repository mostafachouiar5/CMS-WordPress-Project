import { Checkout, LineItemData, Product, TaxProtocol } from '../../types';
interface Store {
    formId: number | string;
    groupId: string;
    mode: 'live' | 'test';
    locks: string[];
    product: Product;
    checkout: Checkout;
    currencyCode: string;
    abandonedCheckoutEnabled: boolean;
    initialLineItems: LineItemData[];
    taxProtocol: TaxProtocol;
    isCheckoutPage: boolean;
    validateStock: boolean;
    persist: 'browser' | 'url' | false;
    paymentMethodRequiresShipping: boolean;
}
declare const state: Store, onChange: import("@stencil/store/dist/types").OnChangeHandler<Store>, on: import("@stencil/store/dist/types").OnHandler<Store>, set: import("@stencil/store/dist/types").Setter<Store>, get: import("@stencil/store/dist/types").Getter<Store>, dispose: () => void, reset: () => void;
export default state;
export { state, onChange, on, set, get, dispose, reset };
