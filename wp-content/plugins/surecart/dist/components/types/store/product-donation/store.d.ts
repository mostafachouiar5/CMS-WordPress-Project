import { Price, Product } from '../../types';
interface Store {
    [key: string]: {
        product: Product;
        selectedPrice: Price;
        ad_hoc_amount: number;
        custom_amount: number;
        amounts: number[];
    };
}
declare const state: Store, onChange: import("@stencil/store/dist/types").OnChangeHandler<Store>, on: import("@stencil/store/dist/types").OnHandler<Store>, set: import("@stencil/store/dist/types").Setter<Store>, get: import("@stencil/store/dist/types").Getter<Store>, dispose: () => void;
export default state;
export { state, onChange, on, set, get, dispose };
