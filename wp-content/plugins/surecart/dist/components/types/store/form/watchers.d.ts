declare const service: import("@xstate/fsm").StateMachine.Service<{
    retries: number;
}, import("@xstate/fsm").EventObject, {
    value: any;
    context: {
        retries: number;
    };
}>;
export default service;
