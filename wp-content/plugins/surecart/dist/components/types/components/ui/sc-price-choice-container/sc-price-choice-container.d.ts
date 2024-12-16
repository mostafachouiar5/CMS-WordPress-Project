import { EventEmitter } from '../../../stencil-public-runtime';
import { Price } from "../../../types";
export declare class ScPriceChoiceContainer {
    /** Stores the price */
    price: string | Price;
    /** Is this loading */
    loading: boolean;
    /** Label for the choice. */
    label: string;
    /** Show the label */
    showLabel: boolean;
    /** Show the price amount */
    showPrice: boolean;
    /** Show the radio/checkbox control */
    showControl: boolean;
    /** Label for the choice. */
    description: string;
    /** Choice Type */
    type: 'checkbox' | 'radio';
    required: boolean;
    /** Is this checked by default */
    checked: boolean;
    priceData: Price;
    scChange: EventEmitter<void>;
    handlePriceChange(): void;
    componentWillLoad(): void;
    renderPrice(): any;
    render(): any;
}
