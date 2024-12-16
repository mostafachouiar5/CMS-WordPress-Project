import { FormState } from '../../../types';
export declare class ScCheckoutUnsavedChangesWarning {
    state: FormState;
    /**
     * Add event listener for beforeunload.
     */
    componentDidLoad(): void;
    /**
     * Warn if status is updaing, finalizing, paying or confirming.
     */
    warnIfUnsavedChanges(e: any): any;
}
