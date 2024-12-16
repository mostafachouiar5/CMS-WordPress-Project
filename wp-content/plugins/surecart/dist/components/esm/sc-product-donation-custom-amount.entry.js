import { r as registerInstance, h, H as Host, a as getElement } from './index-745b6bec.js';
import { s as state } from './watchers-bbcb6e4d.js';
import './index-06061d4e.js';
import './utils-e9ee502a.js';
import './getters-e4172581.js';
import './mutations-d5e8faea.js';
import './remove-query-args-938c53ea.js';
import './add-query-args-0e2a8393.js';
import './index-c5a96d53.js';
import './google-a86aa761.js';
import './currency-a0c9bff4.js';
import './store-7020541e.js';
import './price-d5770168.js';
import './address-b892540d.js';
import './util-50af2a83.js';
import './mutations-01792dfb.js';
import './mutations-ed6d0770.js';
import './index-96490395.js';
import './fetch-2032d11d.js';

const scProductDonationCustomAmountCss = "sc-product-donation-custom-amount sc-price-input sc-button{margin-right:-10px !important}.sc-product-donation-custom-amount sc-button{opacity:0;visibility:hidden;transition:opacity var(--sc-transition-fast) ease-in-out, visibility var(--sc-transition-fast) ease-in-out}.sc-product-donation-custom-amount--has-value sc-button{opacity:1;visibility:visible}";
const ScProductDonationCustomAmountStyle0 = scProductDonationCustomAmountCss;

const ScProductDonationCustomAmount = class {
    constructor(hostRef) {
        registerInstance(this, hostRef);
        this.productId = undefined;
        this.value = undefined;
    }
    state() {
        return state[this.productId];
    }
    updateState(data) {
        state[this.productId] = {
            ...state[this.productId],
            ...data,
        };
    }
    render() {
        var _a, _b, _c, _d, _e, _f, _g, _h, _j, _k;
        const checked = !!((_a = this.state()) === null || _a === void 0 ? void 0 : _a.custom_amount);
        return (h(Host, { key: '7a9b7f513d19b5dfa61fe1199c36ff8af9310e25', class: { 'sc-product-donation-custom-amount': true, 'sc-product-donation-custom-amount--has-value': !!this.value } }, h("sc-choice-container", { key: '053018bee56a379f1fafd534d4ccfb26317d866b', value: `${(_b = this.state()) === null || _b === void 0 ? void 0 : _b.custom_amount}`, "show-control": "false", checked: checked, onClick: () => this.priceInput.triggerFocus(), onKeyDown: () => {
                this.priceInput.triggerFocus();
            }, role: "button" }, h("sc-visually-hidden", { key: '65639092b47669fa4102de1dd3f9985917ed6381' }, wp.i18n.__('Enter a custom amount.', 'surecart')), h("sc-price-input", { key: 'c985e5cfed51496288adb2763d12be39e857f67b', ref: el => (this.priceInput = el), currencyCode: ((_d = (_c = this.state()) === null || _c === void 0 ? void 0 : _c.selectedPrice) === null || _d === void 0 ? void 0 : _d.currency) || ((_e = window === null || window === void 0 ? void 0 : window.scData) === null || _e === void 0 ? void 0 : _e.currency) || 'usd', showCode: false, showLabel: false, value: `${((_f = this.state()) === null || _f === void 0 ? void 0 : _f.custom_amount) || ''}`, onScChange: e => this.updateState({
                ad_hoc_amount: null,
                custom_amount: e.target.value,
            }), min: (_h = (_g = this.state()) === null || _g === void 0 ? void 0 : _g.selectedPrice) === null || _h === void 0 ? void 0 : _h.ad_hoc_min_amount, max: (_k = (_j = this.state()) === null || _j === void 0 ? void 0 : _j.selectedPrice) === null || _k === void 0 ? void 0 : _k.ad_hoc_max_amount, style: { '--sc-input-border-color-focus': 'var(--sc-input-border-color-hover)', '--sc-focus-ring-color-primary': 'transparent' } }))));
    }
    get el() { return getElement(this); }
};
ScProductDonationCustomAmount.style = ScProductDonationCustomAmountStyle0;

export { ScProductDonationCustomAmount as sc_product_donation_custom_amount };

//# sourceMappingURL=sc-product-donation-custom-amount.entry.js.map