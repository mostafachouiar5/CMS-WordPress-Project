import { EventEmitter } from '../../../stencil-public-runtime';
import { Checkout, LineItemData } from '../../../types';
export declare class ScLineItemsProvider {
    /** Order Object */
    order: Checkout;
    /** Holds items to sync */
    syncItems: Array<{
        type: 'toggle' | 'add' | 'remove' | 'update';
        payload: LineItemData;
    }>;
    /** Update line items event */
    scUpdateLineItems: EventEmitter<Array<LineItemData>>;
    /** Handle line item toggle */
    handleLineItemToggle(e: CustomEvent): void;
    /** Handle line item remove */
    handleLineItemRemove(e: CustomEvent): void;
    /** Handle line item add */
    handleLineItemAdd(e: CustomEvent): void;
    /** Handle line item add */
    handleLineItemUpdate(e: CustomEvent): void;
    /** We listen to the syncItems array and run it on the next render in batch */
    syncItemsHandler(val: any): Promise<void>;
    /** Add item to sync */
    addSyncItem(type: 'add' | 'remove' | 'toggle' | 'update', payload: LineItemData): void;
    /** Batch process items to sync before sending */
    processSyncItems(): {
        price_id: string;
        quantity: number;
        variant_id?: string;
    }[];
    /** Add item */
    addItem(item: LineItemData, existingLineData: Array<LineItemData>): LineItemData[];
    /** Toggle item */
    toggleItem(item: LineItemData, existingLineData: Array<LineItemData>): LineItemData[];
    /** Remove item */
    removeItem(item: LineItemData, existingLineData: Array<LineItemData>): LineItemData[];
    /** Update the item item */
    updateItem(item: LineItemData, existingLineData: Array<LineItemData>): LineItemData[];
    render(): any;
}
