import { EventEmitter } from '../../../stencil-public-runtime';
import { FormState } from '../../../types';
/**
 * This component listens for a confirmed event and redirects to the success url.
 */
export declare class ScFormStateProvider {
    /** Holds our state machine service */
    private _stateService;
    /** Loading states for different parts of the form. */
    checkoutState: import("@xstate/fsm").StateMachine.State<{
        retries: number;
    }, import("@xstate/fsm").EventObject, {
        value: any;
        context: {
            retries: number;
        };
    }>;
    /** Set the state. */
    scSetCheckoutFormState: EventEmitter<FormState>;
    /** Set the state. */
    setState(name: any): void;
    /** Watch for checkout state changes and emit to listeners. */
    handleCheckoutStateChange(state: any): void;
    /** Init the state service. */
    componentWillLoad(): void;
    /** Remove state machine on disconnect. */
    disconnectedCallback(): void;
    /** Allow children to set the form state. */
    handleSetStateEvent(e: any): void;
    /** Update the state when the order is paid. */
    handlePaid(): Promise<void>;
    render(): any;
}
