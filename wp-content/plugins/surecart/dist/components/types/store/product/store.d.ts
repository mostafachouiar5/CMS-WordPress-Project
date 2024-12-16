import { ProductState } from "../../types";
import './facebook';
import './google';
interface Store {
    [key: string]: ProductState;
}
declare const state: Store, onChange: import("@stencil/store/dist/types").OnChangeHandler<Store>, on: import("@stencil/store/dist/types").OnHandler<Store>, dispose: () => void, forceUpdate: (key: string | number) => any;
export default state;
export { state, onChange, on, dispose, forceUpdate };
