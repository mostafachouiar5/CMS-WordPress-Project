import { ResponseError } from '../../../types';
export declare class ScLogin {
    private passwordInput;
    private codeInput;
    step: number;
    email: string;
    password: string;
    verifyCode: string;
    loading: boolean;
    error: ResponseError;
    /** Focus the password field automatically on password step. */
    handleStepChange(): void;
    /** Clear out error when loading happens. */
    handleLoadingChange(val: any): void;
    handleVerifyCodeChange(val: any): void;
    /** Handle request errors. */
    handleError(e: any): void;
    /** Submit for verification codes */
    createLoginCode(): Promise<void>;
    /** Get all subscriptions */
    submitCode(): Promise<void>;
    login(): Promise<void>;
    checkEmail(): Promise<void>;
    renderInner(): any;
    render(): any;
}
