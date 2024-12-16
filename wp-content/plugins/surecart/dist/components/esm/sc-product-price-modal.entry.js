import { r as registerInstance, h, a as getElement } from './index-745b6bec.js';
import { o as onChange, s as state, b as setProduct } from './watchers-67501779.js';
import { g as getProductBuyLink, s as submitCartForm, a as getTopLevelError, b as getAdditionalErrorMessages } from './error-ca32663d.js';
import './index-06061d4e.js';
import './google-dd89f242.js';
import './currency-a0c9bff4.js';
import './google-a86aa761.js';
import './utils-e9ee502a.js';
import './util-50af2a83.js';
import './index-c5a96d53.js';
import './mutations-d5e8faea.js';
import './remove-query-args-938c53ea.js';
import './add-query-args-0e2a8393.js';
import './store-7020541e.js';
import './price-d5770168.js';
import './mutations-01792dfb.js';
import './mutations-ed6d0770.js';
import './index-96490395.js';
import './fetch-2032d11d.js';

const scProductPriceModalCss = ":host{display:block}sc-dialog{--body-spacing:var(--sc-spacing-xx-large);color:var(--sc-color-gray-600);text-decoration:none;font-size:16px}.dialog__header{display:flex;align-items:center;gap:var(--sc-spacing-medium)}.dialog__header-text{line-height:var(--sc-line-height-dense)}.dialog__image img{width:60px;height:60px;display:block}.dialog__action{font-weight:var(--sc-font-weight-bold)}.dialog__product-name{font-size:var(--sc-font-size-small)}";
const ScProductPriceModalStyle0 = scProductPriceModalCss;

const ScProductPriceModal = class {
    constructor(hostRef) {
        registerInstance(this, hostRef);
        this.buttonText = undefined;
        this.addToCart = undefined;
        this.productId = undefined;
        this.error = undefined;
    }
    async submit() {
        var _a, _b;
        // if add to cart is undefined/false navigate to buy url
        if (!this.addToCart) {
            const checkoutUrl = (_b = (_a = window === null || window === void 0 ? void 0 : window.scData) === null || _a === void 0 ? void 0 : _a.pages) === null || _b === void 0 ? void 0 : _b.checkout;
            if (!checkoutUrl)
                return;
            return window.location.assign(getProductBuyLink(this.productId, checkoutUrl));
        }
        // submit the cart form.
        try {
            await submitCartForm(this.productId);
        }
        catch (e) {
            console.error(e);
            this.error = e;
        }
    }
    componentWillLoad() {
        // focus on price input when opened.
        onChange(this.productId, () => {
            setTimeout(() => {
                var _a;
                (_a = this.priceInput) === null || _a === void 0 ? void 0 : _a.triggerFocus();
            }, 50);
        });
    }
    render() {
        var _a, _b, _c, _d, _e, _f, _g, _h, _j, _k, _l, _m, _o, _p, _q, _r, _s, _t, _u;
        if (!((_b = (_a = state[this.productId]) === null || _a === void 0 ? void 0 : _a.selectedPrice) === null || _b === void 0 ? void 0 : _b.ad_hoc)) {
            return null;
        }
        return (h("sc-dialog", { open: ((_c = state[this.productId]) === null || _c === void 0 ? void 0 : _c.dialog) === ((this === null || this === void 0 ? void 0 : this.addToCart) ? 'ad_hoc_cart' : 'ad_hoc_buy'), onScRequestClose: () => setProduct(this.productId, { dialog: null }) }, h("span", { class: "dialog__header", slot: "label" }, !!((_e = (_d = state[this.productId]) === null || _d === void 0 ? void 0 : _d.product) === null || _e === void 0 ? void 0 : _e.image_url) && (h("div", { class: "dialog__image" }, h("img", { src: (_g = (_f = state[this.productId]) === null || _f === void 0 ? void 0 : _f.product) === null || _g === void 0 ? void 0 : _g.image_url }))), h("div", { class: "dialog__header-text" }, h("div", { class: "dialog__action" }, wp.i18n.__('Enter An Amount', 'surecart')), h("div", { class: "dialog__product-name" }, (_j = (_h = state[this.productId]) === null || _h === void 0 ? void 0 : _h.product) === null || _j === void 0 ? void 0 : _j.name))), h("sc-form", { onScSubmit: e => {
                e.stopImmediatePropagation();
                this.submit();
            }, onScFormSubmit: e => e.stopImmediatePropagation() }, !!this.error && (h("sc-alert", { type: "danger", scrollOnOpen: true, open: !!this.error, closable: false }, !!getTopLevelError(this.error) && h("span", { slot: "title", innerHTML: getTopLevelError(this.error) }), (getAdditionalErrorMessages(this.error) || []).map((message, index) => (h("div", { innerHTML: message, key: index }))))), h("sc-price-input", { ref: el => (this.priceInput = el), value: (_m = (_l = (_k = state[this.productId]) === null || _k === void 0 ? void 0 : _k.adHocAmount) === null || _l === void 0 ? void 0 : _l.toString) === null || _m === void 0 ? void 0 : _m.call(_l), "currency-code": (_p = (_o = state[this.productId]) === null || _o === void 0 ? void 0 : _o.selectedPrice) === null || _p === void 0 ? void 0 : _p.currency, min: (_r = (_q = state[this.productId]) === null || _q === void 0 ? void 0 : _q.selectedPrice) === null || _r === void 0 ? void 0 : _r.ad_hoc_min_amount, max: (_t = (_s = state[this.productId]) === null || _s === void 0 ? void 0 : _s.selectedPrice) === null || _t === void 0 ? void 0 : _t.ad_hoc_max_amount, onScInput: e => setProduct(this.productId, { adHocAmount: parseInt(e.target.value) }), required: true }), h("sc-button", { type: "primary", full: true, submit: true, busy: (_u = state[this.productId]) === null || _u === void 0 ? void 0 : _u.busy }, h("slot", null, this.buttonText || wp.i18n.__('Add To Cart', 'surecart'))))));
    }
    get el() { return getElement(this); }
};
ScProductPriceModal.style = ScProductPriceModalStyle0;

export { ScProductPriceModal as sc_product_price_modal };

//# sourceMappingURL=sc-product-price-modal.entry.js.map