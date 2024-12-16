import { EventEmitter } from '../../../../stencil-public-runtime';
export declare class ScCartHeader {
    scCloseCart: EventEmitter<void>;
    /** Count the number of items in the cart. */
    getItemsCount(): number;
    render(): any;
}
