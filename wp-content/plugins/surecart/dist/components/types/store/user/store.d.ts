interface Store {
    loggedIn: boolean;
    email: string;
    name: string;
}
declare const state: Store, onChange: import("@stencil/store/dist/types").OnChangeHandler<Store>, dispose: () => void;
export default state;
export { state, onChange, dispose };
