import { Price, Product, Variant } from '../../../../types';
export declare class ScProductCheckoutSelectVariantOption {
    private input;
    el: HTMLScCheckoutProductPriceVariantSelectorElement;
    /** The product. */
    product: Product;
    /** The label for the price. */
    label: string;
    /** The title for price and variant selections */
    selectorTitle: string;
    /** Currently selected variant */
    selectedVariant: Variant;
    /** Currently selected price */
    selectedPrice: Price;
    /** The first selected option value */
    option1: string;
    /** The second selected option value */
    option2: string;
    /** The third selected option value */
    option3: string;
    /** When option values are selected, attempt to find a matching variant. */
    handleOptionChange(): void;
    /**
     * Is the selected variant out of stock?
     * @returns {boolean} Whether the selected variant is out of stock.
     */
    isSelectedVariantOutOfStock(): boolean;
    /**
     * Do we have the required selected variant?
     * @returns {boolean} Whether the product has a required variant and it is not selected.
     */
    hasRequiredSelectedVariant(): string | true;
    reportValidity(): Promise<boolean>;
    getSelectedPrice(): Price;
    /** When selected variant and selected price are set, we can update the checkout. */
    updateLineItems(): Promise<void>;
    private removeListener;
    componentWillLoad(): void;
    disconnectedCallback(): void;
    lineItem(): import("../../../../types").LineItem;
    hasVariants(): boolean;
    render(): any;
}
