import { EventEmitter } from '../../../../stencil-public-runtime';
import { LineItemData } from '../../../../types';
export declare class ScPriceChoices {
    el: HTMLScPriceChoicesElement;
    /** Selector label */
    label: string;
    /** Number of columns */
    columns: number;
    /** Required by default */
    required: boolean;
    /** Toggle line item event */
    scRemoveLineItem: EventEmitter<LineItemData>;
    /** Toggle line item event */
    scUpdateLineItem: EventEmitter<LineItemData>;
    handleChange(): void;
    render(): any;
}
