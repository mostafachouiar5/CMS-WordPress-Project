import { EventEmitter } from '../../../../stencil-public-runtime';
import { LineItemData } from "../../../../types";
export declare class ScProductSelectedPrice {
    /** The input reference */
    private input;
    /** The product id. */
    productId: string;
    /** Show the input? */
    showInput: boolean;
    /** The adHocAmount */
    adHocAmount: number;
    /** Toggle line item event */
    scUpdateLineItem: EventEmitter<LineItemData>;
    /** The line item from state. */
    lineItem(): import("src/types").LineItem;
    componentWillLoad(): void;
    updatePrice(): void;
    handleShowInputChange(val: any): void;
    onSubmit(e: any): void;
    render(): any;
}
