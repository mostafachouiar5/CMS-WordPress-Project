import { WordPressUser } from '../../../../types';
export declare class ScWordPressPasswordEdit {
    heading: string;
    successUrl: string;
    user: WordPressUser;
    loading: boolean;
    error: string;
    /** Ensures strong password validation. */
    enableValidation: boolean;
    renderEmpty(): any;
    validatePassword(password: string): boolean;
    handleSubmit(e: any): Promise<void>;
    render(): any;
}
