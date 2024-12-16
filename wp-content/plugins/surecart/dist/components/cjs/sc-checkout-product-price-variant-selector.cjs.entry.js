'use strict';

Object.defineProperty(exports, '__esModule', { value: true });

const index = require('./index-8acc3c89.js');
const getters = require('./getters-d2606216.js');
const mutations = require('./mutations-19357660.js');
const util = require('./util-b877b2bd.js');
const index$1 = require('./index-771f480e.js');
const mutations$1 = require('./mutations-11c8f9a8.js');
const utils = require('./utils-ee1bb9d3.js');
require('./address-4c70d641.js');
require('./index-bcdafe6e.js');
require('./remove-query-args-b57e8cd3.js');
require('./add-query-args-49dcb630.js');
require('./index-fb76df07.js');
require('./google-59d23803.js');
require('./currency-71fce0f0.js');
require('./store-1fb3d249.js');
require('./price-653ec1cb.js');
require('./fetch-f25a0cb0.js');

const scCheckoutProductPriceVariantSelectorCss = "sc-checkout-product-price-variant-selector{display:block}.sc-checkout-product-price-variant-selector{position:relative}.sc-checkout-product-price-variant-selector>*:not(:last-child){display:block;margin-bottom:var(--sc-form-row-spacing, 0.75em)}.sc-checkout-product-price-variant-selector__pills-wrapper{display:flex;flex-wrap:wrap;gap:var(--sc-spacing-x-small)}.sc-checkout-product-price-variant-selector__hidden-input{position:absolute !important;top:0 !important;left:0 !important;opacity:0 !important;padding:0px !important;margin:0px !important;pointer-events:none !important;width:0 !important}";
const ScCheckoutProductPriceVariantSelectorStyle0 = scCheckoutProductPriceVariantSelectorCss;

const ScProductCheckoutSelectVariantOption = class {
    constructor(hostRef) {
        index.registerInstance(this, hostRef);
        this.product = undefined;
        this.label = undefined;
        this.selectorTitle = undefined;
        this.selectedVariant = undefined;
        this.selectedPrice = undefined;
        this.option1 = undefined;
        this.option2 = undefined;
        this.option3 = undefined;
    }
    /** When option values are selected, attempt to find a matching variant. */
    handleOptionChange() {
        var _a, _b;
        this.selectedVariant = util.getVariantFromValues({
            variants: (_b = (_a = this.product) === null || _a === void 0 ? void 0 : _a.variants) === null || _b === void 0 ? void 0 : _b.data,
            values: {
                ...(this.option1 ? { option_1: this.option1 } : {}),
                ...(this.option2 ? { option_2: this.option2 } : {}),
                ...(this.option3 ? { option_3: this.option3 } : {}),
            },
        });
    }
    /**
     * Is the selected variant out of stock?
     * @returns {boolean} Whether the selected variant is out of stock.
     */
    isSelectedVariantOutOfStock() {
        var _a, _b;
        return ((_a = this.product) === null || _a === void 0 ? void 0 : _a.stock_enabled) && this.hasVariants() && !((_b = this.product) === null || _b === void 0 ? void 0 : _b.allow_out_of_stock_purchases) && this.selectedVariant.available_stock < 1;
    }
    /**
     * Do we have the required selected variant?
     * @returns {boolean} Whether the product has a required variant and it is not selected.
     */
    hasRequiredSelectedVariant() {
        var _a;
        if (!this.hasVariants()) {
            return true;
        }
        return (_a = this.selectedVariant) === null || _a === void 0 ? void 0 : _a.id;
    }
    async reportValidity() {
        this.input.setCustomValidity('');
        if (!this.hasVariants()) {
            return this.input.reportValidity();
        }
        // We don't have a required selected variant.
        if (!this.hasRequiredSelectedVariant()) {
            this.input.setCustomValidity(wp.i18n.__('Please choose an available option.', 'surecart'));
            return this.input.reportValidity();
        }
        // don't let the person checkout with an out of stock selection.
        if (this.isSelectedVariantOutOfStock()) {
            this.input.setCustomValidity(wp.i18n.__('This selection is not available.', 'surecart'));
            return this.input.reportValidity();
        }
        return this.input.reportValidity();
    }
    getSelectedPrice() {
        var _a, _b, _c, _d, _e;
        if (((_c = (_b = (_a = this.product) === null || _a === void 0 ? void 0 : _a.prices) === null || _b === void 0 ? void 0 : _b.data) === null || _c === void 0 ? void 0 : _c.length) === 1) {
            return (_e = (_d = this.product) === null || _d === void 0 ? void 0 : _d.prices) === null || _e === void 0 ? void 0 : _e.data[0];
        }
        return this.selectedPrice;
    }
    /** When selected variant and selected price are set, we can update the checkout. */
    async updateLineItems() {
        var _a, _b, _c, _d, _e;
        const selectedPrice = this.getSelectedPrice();
        // We need a price.
        if (!(selectedPrice === null || selectedPrice === void 0 ? void 0 : selectedPrice.id))
            return;
        // get the existing line item.
        const lineItem = this.lineItem();
        // no changes.
        if (((_a = lineItem === null || lineItem === void 0 ? void 0 : lineItem.price) === null || _a === void 0 ? void 0 : _a.id) === (selectedPrice === null || selectedPrice === void 0 ? void 0 : selectedPrice.id) && ((_b = lineItem === null || lineItem === void 0 ? void 0 : lineItem.variant) === null || _b === void 0 ? void 0 : _b.id) === ((_c = this.selectedVariant) === null || _c === void 0 ? void 0 : _c.id))
            return;
        // We need a selected variant if this product has variants.
        if (!this.hasRequiredSelectedVariant())
            return;
        // Don't let the person checkout with an out of stock selection.
        if (this.isSelectedVariantOutOfStock())
            return;
        // create or update the
        try {
            mutations.updateFormState('FETCH');
            if (lineItem === null || lineItem === void 0 ? void 0 : lineItem.id) {
                mutations.state.checkout = await index$1.updateLineItem({
                    id: lineItem === null || lineItem === void 0 ? void 0 : lineItem.id,
                    data: {
                        variant: (_d = this.selectedVariant) === null || _d === void 0 ? void 0 : _d.id,
                        price: selectedPrice === null || selectedPrice === void 0 ? void 0 : selectedPrice.id,
                        quantity: 1,
                    },
                });
            }
            else {
                mutations.state.checkout = await index$1.addLineItem({
                    checkout: mutations.state.checkout,
                    data: {
                        variant: (_e = this.selectedVariant) === null || _e === void 0 ? void 0 : _e.id,
                        price: selectedPrice === null || selectedPrice === void 0 ? void 0 : selectedPrice.id,
                        quantity: 1,
                    },
                });
            }
            mutations.updateFormState('RESOLVE');
        }
        catch (e) {
            console.error(e);
            mutations$1.createErrorNotice(e);
            mutations.updateFormState('REJECT');
        }
    }
    componentWillLoad() {
        // when checkout changes, update the selected variant and price.
        this.removeListener = mutations.onChange('checkout', () => {
            var _a, _b, _c;
            const lineItem = this.lineItem();
            this.selectedVariant = lineItem === null || lineItem === void 0 ? void 0 : lineItem.variant;
            this.selectedPrice = lineItem === null || lineItem === void 0 ? void 0 : lineItem.price;
            this.option1 = (_a = lineItem === null || lineItem === void 0 ? void 0 : lineItem.variant) === null || _a === void 0 ? void 0 : _a.option_1;
            this.option2 = (_b = lineItem === null || lineItem === void 0 ? void 0 : lineItem.variant) === null || _b === void 0 ? void 0 : _b.option_2;
            this.option3 = (_c = lineItem === null || lineItem === void 0 ? void 0 : lineItem.variant) === null || _c === void 0 ? void 0 : _c.option_3;
        });
    }
    // remove listener to prevent leaks.
    disconnectedCallback() {
        this.removeListener();
    }
    // get the line item by product id.
    lineItem() {
        var _a;
        return getters.getLineItemByProductId((_a = this.product) === null || _a === void 0 ? void 0 : _a.id);
    }
    hasVariants() {
        var _a, _b, _c;
        return ((_c = (_b = (_a = this.product) === null || _a === void 0 ? void 0 : _a.variants) === null || _b === void 0 ? void 0 : _b.data) === null || _c === void 0 ? void 0 : _c.length) > 0;
    }
    render() {
        var _a, _b, _c, _d, _e;
        return (index.h("sc-form-control", { key: '681c7ac282ff7accf41f90dff4b8d1f3fd757cdc', class: "sc-checkout-product-price-variant-selector", label: this.selectorTitle }, (this.product.variant_options.data || []).map(({ name, values }, index$1) => (index.h("sc-form-control", { label: name }, index.h("div", { class: "sc-checkout-product-price-variant-selector__pills-wrapper" }, (values || []).map(value => {
            const args = [
                index$1 + 1,
                value,
                {
                    ...(this.option1 ? { option_1: this.option1 } : {}),
                    ...(this.option2 ? { option_2: this.option2 } : {}),
                    ...(this.option3 ? { option_3: this.option3 } : {}),
                },
                this.product,
            ];
            const isUnavailable = utils.isProductVariantOptionSoldOut.apply(void 0, args) || utils.isProductVariantOptionMissing.apply(void 0, args);
            return (index.h("sc-pill-option", { isUnavailable: isUnavailable, isSelected: this[`option${index$1 + 1}`] === value, onClick: () => (this[`option${index$1 + 1}`] = value) }, index.h("span", { "aria-hidden": "true" }, value), index.h("sc-visually-hidden", null, wp.i18n.sprintf(wp.i18n.__('Select %s: %s', 'surecart'), name, value), isUnavailable && index.h(index.Fragment, null, " ", wp.i18n.__('(option unavailable)', 'surecart')))));
        }))))), ((_c = (_b = (_a = this.product) === null || _a === void 0 ? void 0 : _a.prices) === null || _b === void 0 ? void 0 : _b.data) === null || _c === void 0 ? void 0 : _c.length) > 1 && (index.h("sc-form-control", { key: '95dd37f4a1ba6809c62fe98be4f92b4f72e37da4', label: !!((_d = this.product.variant_options.data) === null || _d === void 0 ? void 0 : _d.length) ? this.label : null }, index.h("sc-choices", { key: 'b19a8269112f6fdc975104c1bd9a2a294ce6e7bb' }, (this.product.prices.data || [])
            .sort((a, b) => (a === null || a === void 0 ? void 0 : a.position) - (b === null || b === void 0 ? void 0 : b.position))
            .map(price => {
            var _a, _b, _c;
            return (index.h("sc-price-choice-container", { required: true, price: price, label: (price === null || price === void 0 ? void 0 : price.name) || ((_a = this.product) === null || _a === void 0 ? void 0 : _a.name), checked: ((_c = (_b = this.lineItem()) === null || _b === void 0 ? void 0 : _b.price) === null || _c === void 0 ? void 0 : _c.id) === (price === null || price === void 0 ? void 0 : price.id), onScChange: e => {
                    if (e.target.checked) {
                        this.selectedPrice = price;
                    }
                } }));
        })))), index.h("input", { key: '4fdf82b33bcf54d440f1f279d3823f9e3469d93d', class: "sc-checkout-product-price-variant-selector__hidden-input", ref: el => (this.input = el), value: (_e = this.selectedVariant) === null || _e === void 0 ? void 0 : _e.id })));
    }
    get el() { return index.getElement(this); }
    static get watchers() { return {
        "option1": ["handleOptionChange"],
        "option2": ["handleOptionChange"],
        "option3": ["handleOptionChange"],
        "selectedVariant": ["updateLineItems"],
        "selectedPrice": ["updateLineItems"]
    }; }
};
ScProductCheckoutSelectVariantOption.style = ScCheckoutProductPriceVariantSelectorStyle0;

exports.sc_checkout_product_price_variant_selector = ScProductCheckoutSelectVariantOption;

//# sourceMappingURL=sc-checkout-product-price-variant-selector.cjs.entry.js.map