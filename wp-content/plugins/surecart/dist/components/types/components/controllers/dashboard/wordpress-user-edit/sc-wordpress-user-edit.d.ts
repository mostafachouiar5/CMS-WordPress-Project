import { WordPressUser } from '../../../../types';
export declare class ScWordPressUserEdit {
    heading: string;
    successUrl: string;
    user: WordPressUser;
    loading: boolean;
    error: string;
    renderEmpty(): any;
    handleSubmit(e: any): Promise<void>;
    render(): any;
}
