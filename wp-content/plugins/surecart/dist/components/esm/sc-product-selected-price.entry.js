import { r as registerInstance, c as createEvent, h, F as Fragment, H as Host } from './index-745b6bec.js';
import { i as intervalString } from './price-d5770168.js';
import { g as getLineItemByProductId } from './getters-e4172581.js';
import { f as formBusy } from './getters-929aa1df.js';
import { o as onChange } from './mutations-d5e8faea.js';
import './currency-a0c9bff4.js';
import './address-b892540d.js';
import './store-7020541e.js';
import './index-06061d4e.js';
import './utils-e9ee502a.js';
import './remove-query-args-938c53ea.js';
import './add-query-args-0e2a8393.js';
import './index-c5a96d53.js';
import './google-a86aa761.js';

const scProductSelectedPriceCss = ":host{display:block}sc-form{width:100%}.selected-price{display:flex;align-items:center;gap:var(--sc-spacing-small);flex-wrap:wrap}.selected-price__wrap{display:flex;align-items:baseline;flex-wrap:wrap;gap:var(--sc-spacing-xx-small);color:var(--sc-selected-price-color, var(--sc-color-gray-800));line-height:1}.selected-price__price{font-size:var(--sc-font-size-xxx-large);font-weight:var(--sc-font-weight-bold);white-space:nowrap}.selected-price__interval{font-weight:var(--sc-font-weight-bold);opacity:0.65;white-space:nowrap}.selected-price__scratch-price{opacity:0.65;font-weight:var(--sc-font-weight-normal);text-decoration:line-through}";
const ScProductSelectedPriceStyle0 = scProductSelectedPriceCss;

const ScProductSelectedPrice = class {
    constructor(hostRef) {
        registerInstance(this, hostRef);
        this.scUpdateLineItem = createEvent(this, "scUpdateLineItem", 7);
        this.productId = undefined;
        this.showInput = undefined;
        this.adHocAmount = undefined;
    }
    /** The line item from state. */
    lineItem() {
        return getLineItemByProductId(this.productId);
    }
    componentWillLoad() {
        onChange('checkout', () => {
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
        const price = (_a = this.lineItem()) === null || _a === void 0 ? void 0 : _a.price;
        const variant = (_b = this.lineItem()) === null || _b === void 0 ? void 0 : _b.variant;
        if (!price)
            return h(Host, { style: { display: 'none' } });
        return (h("div", { class: { 'selected-price': true } }, this.showInput ? (h("sc-form", { onScSubmit: e => this.onSubmit(e), onScFormSubmit: e => {
                e.preventDefault();
                e.stopImmediatePropagation();
            } }, h("sc-price-input", { ref: el => (this.input = el), size: "large", "currency-code": (price === null || price === void 0 ? void 0 : price.currency) || 'usd', min: price === null || price === void 0 ? void 0 : price.ad_hoc_min_amount, max: price === null || price === void 0 ? void 0 : price.ad_hoc_max_amount, placeholder: '0.00', required: true, value: (_d = (_c = this.adHocAmount) === null || _c === void 0 ? void 0 : _c.toString) === null || _d === void 0 ? void 0 : _d.call(_c), onScInput: e => (this.adHocAmount = parseFloat(e.target.value)), onKeyDown: e => {
                if (e.key === 'Enter') {
                    this.onSubmit(e);
                }
            } }, h("sc-button", { slot: "suffix", type: "link", submit: true }, wp.i18n.__('Update', 'surecart'))))) : (h(Fragment, null, h("div", { class: "selected-price__wrap" }, h("span", { class: "selected-price__price", "aria-label": wp.i18n.__('Product price', 'surecart') }, (price === null || price === void 0 ? void 0 : price.scratch_amount) > price.amount && (h(Fragment, null, h("sc-format-number", { class: "selected-price__scratch-price", part: "price__scratch", type: "currency", currency: price === null || price === void 0 ? void 0 : price.currency, value: price === null || price === void 0 ? void 0 : price.scratch_amount }), ' ')), h("sc-format-number", { type: "currency", currency: price === null || price === void 0 ? void 0 : price.currency, value: ((_e = this.lineItem()) === null || _e === void 0 ? void 0 : _e.ad_hoc_amount) !== null ? (_f = this.lineItem()) === null || _f === void 0 ? void 0 : _f.ad_hoc_amount : (variant === null || variant === void 0 ? void 0 : variant.amount) || (price === null || price === void 0 ? void 0 : price.amount) })), h("span", { class: "selected-price__interval", "aria-label": wp.i18n.__('Price interval', 'surecart') }, intervalString(price, {
            labels: {
                interval: '/',
                period: 
                /** translators: used as in time period: "for 3 months" */
                wp.i18n.__('for', 'surecart'),
            },
        }))), (price === null || price === void 0 ? void 0 : price.ad_hoc) && !formBusy() && (h("sc-button", { class: "selected-price__change-amount", type: "primary", size: "small", onClick: () => (this.showInput = true) }, h("sc-icon", { name: "edit", slot: "prefix" }), wp.i18n.__('Change Amount', 'surecart')))))));
    }
    static get watchers() { return {
        "showInput": ["handleShowInputChange"]
    }; }
};
ScProductSelectedPrice.style = ScProductSelectedPriceStyle0;

export { ScProductSelectedPrice as sc_product_selected_price };

//# sourceMappingURL=sc-product-selected-price.entry.js.map