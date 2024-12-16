export declare const checkoutMachine: import("@xstate/fsm").StateMachine.Machine<{
    retries: number;
}, import("@xstate/fsm").EventObject, {
    value: any;
    context: {
        retries: number;
    };
}>;
export default checkoutMachine;
