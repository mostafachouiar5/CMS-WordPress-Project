interface Store {
    id: string;
    method: string;
    manual: boolean;
}
declare const state: Store, onChange: import("@stencil/store/dist/types").OnChangeHandler<Store>, dispose: () => void;
export default state;
export { state, onChange, dispose };
