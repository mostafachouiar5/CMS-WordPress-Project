interface Store {
    formState: any;
    text: {
        loading: {
            finalizing: string;
            paying: string;
            confirming: string;
            confirmed: string;
            redirecting: string;
        };
        success: {
            title: string;
            description: string;
            button: string;
        };
    };
}
declare const state: Store, onChange: import("@stencil/store/dist/types").OnChangeHandler<Store>, on: import("@stencil/store/dist/types").OnHandler<Store>, set: import("@stencil/store/dist/types").Setter<Store>, get: import("@stencil/store/dist/types").Getter<Store>, dispose: () => void;
export default state;
export { state, onChange, on, set, get, dispose };
