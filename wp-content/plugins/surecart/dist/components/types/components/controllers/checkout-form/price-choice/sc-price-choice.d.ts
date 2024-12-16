import { EventEmitter } from '../../../../stencil-public-runtime';
import { LineItemData, Checkout, Price, Prices, Product, Products, ResponseError } from '../../../../types';
export declare class ScPriceChoice {
    private adHocInput;
    private choice;
    /** Id of the price. */
    priceId: string;
    /** Stores the price */
    price: Price;
    /** Stores the price */
    product: Product;
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
    /** Price entities */
    prices: Prices;
    /** Product entity */
    products: Products;
    /** Session */
    order: Checkout;
    /** Default quantity */
    quantity: number;
    /** Choice Type */
    type: 'checkbox' | 'radio';
    /** Is this checked by default */
    checked: boolean;
    /** Errors from response */
    error: ResponseError;
    /** Is this an ad-hoc price choice */
    isAdHoc: Boolean;
    /** Is this blank? */
    blank: boolean;
    /** Toggle line item event */
    scUpdateLineItem: EventEmitter<LineItemData>;
    /** Toggle line item event */
    scRemoveLineItem: EventEmitter<LineItemData>;
    /** Add entities */
    scAddEntities: EventEmitter<any>;
    /** Stores the error message */
    errorMessage: string;
    /** Stores the error message */
    adHocErrorMessage: string;
    /** Refetch if price changes */
    handlePriceIdChage(): void;
    /** Keep price up to date. */
    handlePricesChange(): void;
    handlePriseChange(): void;
    handleErrorsChange(): void;
    handleCheckedChange(): void;
    /** Fetch on load */
    componentWillLoad(): void;
    /** Fetch prices and products */
    fetchPriceWithProduct(): Promise<void>;
    /** Is this price in the checkout session. */
    isInOrder(): boolean;
    /** Is this checked */
    isChecked(): boolean;
    onChangeAdHoc(e: any): void;
    getLineItem(): import("../../../../types").LineItem;
    /** Show we show the ad hoc price box */
    showAdHoc(): boolean;
    renderEmpty(): any;
    renderPrice(): any;
    render(): any;
}
