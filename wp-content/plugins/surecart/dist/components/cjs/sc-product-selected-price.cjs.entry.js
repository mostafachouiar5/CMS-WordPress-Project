'use strict';

Object.defineProperty(exports, '__esModule', { value: true });

const index = require('./index-8acc3c89.js');
const price = require('./price-653ec1cb.js');
const getters = require('./getters-d2606216.js');
const getters$1 = require('./getters-690e042a.js');
const mutations = require('./mutations-19357660.js');
require('./currency-71fce0f0.js');
require('./address-4c70d641.js');
require('./store-1fb3d249.js');
require('./index-bcdafe6e.js');
require('./utils-ee1bb9d3.js');
require('./remove-query-args-b57e8cd3.js');
require('./add-query-args-49dcb630.js');
require('./index-fb76df07.js');
require('./google-59d23803.js');

const scProductSelectedPriceCss = ":host{display:block}sc-form{width:100%}.selected-price{display:flex;align-items:center;gap:var(--sc-spacing-small);flex-wrap:wrap}.selected-price__wrap{display:flex;align-items:baseline;flex-wrap:wrap;gap:var(--sc-spacing-xx-small);color:var(--sc-selected-price-color, var(--sc-color-gray-800));line-height:1}.selected-price__price{font-size:var(--sc-font-size-xxx-large);font-weight:var(--sc-font-weight-bold);white-space:nowrap}.selected-price__interval{font-weight:var(--sc-font-weight-bold);opacity:0.65;white-space:nowrap}.selected-price__scratch-price{opacity:0.65;font-weight:var(--sc-font-weight-normal);text-decoration:line-through}";
const ScProductSelectedPriceStyle0 = scProductSelectedPriceCss;

const ScProductSelectedPrice = class {
    constructor(hostRef) {
        index.registerInstance(this, hostRef);
        this.scUpdateLineItem = index.createEvent(this, "scUpdateLineItem", 7);
        this.productId = undefined;
        this.showInput = undefined;
        this.adHocAmount = undefined;
    }
    /** The line item from state. */
    lineItem() {
        return getters.getLineItemByProductId(this.productId);
    }
    componentWillLoad() {
        mutations.onChange('checkout', () => {
            var _a, _b, _c;
            this.adHocAmount = ((_a = this.lineItem()) === null || _a === void 0 ? void 0 : _a.ad_hoc_amount) || ((_c = (_b = this.lineItem()) === null || _b === void 0 ? void 0 : _b.price) === null || _c === void 0 ? void 0 : _c.amount);
        });
    }
    updatePrice() {
        var _a, _b, _c;
        this.showInput = false;
        if (!this.adHocAmount && this.adHocAmount !== 0)
            return;
        if (this.adHocAmount === ((_a = this.lineItem()) === null || _a === void 0 ? void 0 : _a.ad_hoc_amount))
            return;
        this.scUpdateLineItem.emit({ price_id: (_c = (_b = this.lineItem()) === null || _b === void 0 ? void 0 : _b.price) === null || _c === void 0 ? void 0 : _c.id, quantity: 1, ad_hoc_amount: this.adHocAmount });
    }
    handleShowInputChange(val) {
        if (val) {
            setTimeout(() => {
                this.input.triggerFocus();
            }, 50);
        }
    }
    onSubmit(e) {
        e.preventDefault();
        e.stopImmediatePropagation();
        this.updatePrice();
    }
    render() {
        var _a, _b, _c, _d, _e, _f;
        const price$1 = (_a = this.lineItem()) === null || _a === void 0 ? void 0 : _a.price;
        const variant = (_b = this.lineItem()) === null || _b === void 0 ? void 0 : _b.variant;
        if (!price$1)
            return index.h(index.Host, { style: { display: 'none' } });
        return (index.h("div", { class: { 'selected-price': true } }, this.showInput ? (index.h("sc-form", { onScSubmit: e => this.onSubmit(e), onScFormSubmit: e => {
                e.preventDefault();
                e.stopImmediatePropagation();
            } }, index.h("sc-price-input", { ref: el => (this.input = el), size: "large", "currency-code": (price$1 === null || price$1 === void 0 ? void 0 : price$1.currency) || 'usd', min: price$1 === null || price$1 === void 0 ? void 0 : price$1.ad_hoc_min_amount, max: price$1 === null || price$1 === void 0 ? void 0 : price$1.ad_hoc_max_amount, placeholder: '0.00', required: true, value: (_d = (_c = this.adHocAmount) === null || _c === void 0 ? void 0 : _c.toString) === null || _d === void 0 ? void 0 : _d.call(_c), onScInput: e => (this.adHocAmount = parseFloat(e.target.value)), onKeyDown: e => {
                if (e.key === 'Enter') {
                    this.onSubmit(e);
                }
            } }, index.h("sc-button", { slot: "suffix", type: "link", submit: true }, wp.i18n.__('Update', 'surecart'))))) : (index.h(index.Fragment, null, index.h("div", { class: "selected-price__wrap" }, index.h("span", { class: "selected-price__price", "aria-label": wp.i18n.__('Product price', 'surecart') }, (price$1 === null || price$1 === void 0 ? void 0 : price$1.scratch_amount) > price$1.amount && (index.h(index.Fragment, null, index.h("sc-format-number", { class: "selected-price__scratch-price", part: "price__scratch", type: "currency", currency: price$1 === null || price$1 === void 0 ? void 0 : price$1.currency, value: price$1 === null || price$1 === void 0 ? void 0 : price$1.scratch_amount }), ' ')), index.h("sc-format-number", { type: "currency", currency: price$1 === null || price$1 === void 0 ? void 0 : price$1.currency, value: ((_e = this.lineItem()) === null || _e === void 0 ? void 0 : _e.ad_hoc_amount) !== null ? (_f = this.lineItem()) === null || _f === void 0 ? void 0 : _f.ad_hoc_amount : (variant === null || variant === void 0 ? void 0 : variant.amount) || (price$1 === null || price$1 === void 0 ? void 0 : price$1.amount) })), index.h("span", { class: "selected-price__interval", "aria-label": wp.i18n.__('Price interval', 'surecart') }, price.intervalString(price$1, {
            labels: {
                interval: '/',
                period: 
                /** translators: used as in time period: "for 3 months" */
                wp.i18n.__('for', 'surecart'),
            },
        }))), (price$1 === null || price$1 === void 0 ? void 0 : price$1.ad_hoc) && !getters$1.formBusy() && (index.h("sc-button", { class: "selected-price__change-amount", type: "primary", size: "small", onClick: () => (this.showInput = true) }, index.h("sc-icon", { name: "edit", slot: "prefix" }), wp.i18n.__('Change Amount', 'surecart')))))));
    }
    static get watchers() { return {
        "showInput": ["handleShowInputChange"]
    }; }
};
ScProductSelectedPrice.style = ScProductSelectedPriceStyle0;

exports.sc_product_selected_price = ScProductSelectedPrice;

//# sourceMappingURL=sc-product-selected-price.cjs.entry.js.map