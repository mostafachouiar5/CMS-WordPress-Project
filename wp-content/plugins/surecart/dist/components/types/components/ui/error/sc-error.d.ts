/**
 * External dependencies.
 */
import { EventEmitter } from '../../../stencil-public-runtime';
import { ResponseError } from '../../../types';
/**
 * @part base - The elements base wrapper.
 * @part icon - The alert icon.
 * @part text - The alert text.
 * @part title - The alert title.
 * @part message - The alert message.
 * @part close - The close icon.
 */
export declare class ScFormErrorProvider {
    /** Set the state. */
    scUpdateError: EventEmitter<ResponseError>;
    /** Error to display. */
    error: ResponseError | null;
    /** Trigger the error event when an error happens  */
    handleErrorUpdate(val: any): void;
    render(): any;
}
