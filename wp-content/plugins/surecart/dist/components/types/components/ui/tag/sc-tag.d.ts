import { EventEmitter } from '../../../stencil-public-runtime';
export declare class ScTag {
    scClear: EventEmitter<ScTag>;
    /** The tag's type. */
    type: 'primary' | 'success' | 'info' | 'warning' | 'danger' | 'default';
    /** The tag's size. */
    size: 'small' | 'medium' | 'large';
    /** Draws a pill-style tag with rounded edges. */
    pill: boolean;
    /** Makes the tag clearable. */
    clearable: boolean;
    /** Aria label */
    ariaLabel: string;
    handleClearClick(): void;
    render(): any;
}
