import { Price } from '../../../types';
export declare class ScPriceRange {
    /**The array of price objects */
    prices: Price[];
    private minPrice;
    private maxPrice;
    handlePricesChange(): void;
    componentWillLoad(): void;
    render(): any;
}
