import { EventEmitter } from '../../../stencil-public-runtime';
import { Price, Product } from "../../../types";
export declare class ScRecurringPriceChoiceContainer {
    /** The prices to choose from. */
    prices: Price[];
    /** The currently selected price */
    selectedPrice: Price;
    /** The internal currently selected option state */
    selectedOption: Price;
    /** The product. */
    product: Product;
    /** Label for the choice. */
    label: string;
    /** Show the radio/checkbox control */
    showControl: boolean;
    /** Should we show the price? */
    showAmount: boolean;
    /** Should we show the price details? */
    showDetails: boolean;
    /** Change event. */
    scChange: EventEmitter<string>;
    renderPrice(price: any): any;
    value(): Price;
    selectedPriceState(): Price;
    render(): any;
}
