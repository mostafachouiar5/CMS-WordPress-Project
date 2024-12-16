declare const store: import("@stencil/store").ObservableMap<{
    live: any;
    test: any;
}>;
declare const state: {
    live: any;
    test: any;
}, onChange: import("@stencil/store/dist/types").OnChangeHandler<{
    live: any;
    test: any;
}>, on: import("@stencil/store/dist/types").OnHandler<{
    live: any;
    test: any;
}>, set: import("@stencil/store/dist/types").Setter<{
    live: any;
    test: any;
}>, get: import("@stencil/store/dist/types").Getter<{
    live: any;
    test: any;
}>, dispose: () => void;
export default store;
export { state, onChange, on, set, get, dispose };
