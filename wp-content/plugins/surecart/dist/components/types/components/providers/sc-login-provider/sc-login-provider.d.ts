import { EventEmitter } from '../../../stencil-public-runtime';
import { Checkout } from '../../../types';
export declare class ScLoginProvider {
    private loginForm;
    /** Is the user logged in. */
    loggedIn: boolean;
    order: Checkout;
    scSetLoggedIn: EventEmitter<boolean>;
    scSetCustomer: EventEmitter<{
        email: string;
        name?: string;
    }>;
    notice: boolean;
    open: boolean;
    loading: boolean;
    error: string;
    /** Listen for open event. */
    handleLoginPrompt(): void;
    /** Focus on first input. */
    handleLoginDialogChange(val: any): void;
    handleLoggedInChange(val: any, prev: any): void;
    handleOrderChange(val: any, prev: any): void;
    /** Handle form submit. */
    handleFormSubmit(e: any): Promise<void>;
    render(): any;
}
