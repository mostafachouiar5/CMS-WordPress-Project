export declare class ScPasswordNag {
    private input;
    open: boolean;
    /** The type of alert. */
    type: 'primary' | 'success' | 'info' | 'warning' | 'danger';
    /** The success url. */
    successUrl: string;
    /** Set a new password */
    set: boolean;
    loading: boolean;
    error: string;
    success: boolean;
    /** Ensures strong password validation. */
    enableValidation: boolean;
    handleSetChange(): void;
    /** Dismiss the form. */
    dismiss(): Promise<void>;
    validatePassword(password: string): boolean;
    /** Handle password submit. */
    handleSubmit(e: any): Promise<void>;
    render(): any;
}
