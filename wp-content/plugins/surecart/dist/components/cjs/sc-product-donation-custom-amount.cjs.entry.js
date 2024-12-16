'use strict';

Object.defineProperty(exports, '__esModule', { value: true });

const index = require('./index-8acc3c89.js');
const watchers = require('./watchers-39bf88bb.js');
require('./index-bcdafe6e.js');
require('./utils-ee1bb9d3.js');
require('./getters-d2606216.js');
require('./mutations-19357660.js');
require('./remove-query-args-b57e8cd3.js');
require('./add-query-args-49dcb630.js');
require('./index-fb76df07.js');
require('./google-59d23803.js');
require('./currency-71fce0f0.js');
require('./store-1fb3d249.js');
require('./price-653ec1cb.js');
require('./address-4c70d641.js');
require('./util-b877b2bd.js');
require('./mutations-6484d4a1.js');
require('./mutations-11c8f9a8.js');
require('./index-771f480e.js');
require('./fetch-f25a0cb0.js');

const scProductDonationCustomAmountCss = "sc-product-donation-custom-amount sc-price-input sc-button{margin-right:-10px !important}.sc-product-donation-custom-amount sc-button{opacity:0;visibility:hidden;transition:opacity var(--sc-transition-fast) ease-in-out, visibility var(--sc-transition-fast) ease-in-out}.sc-product-donation-custom-amount--has-value sc-button{opacity:1;visibility:visible}";
const ScProductDonationCustomAmountStyle0 = scProductDonationCustomAmountCss;

const ScProductDonationCustomAmount = class {
    constructor(hostRef) {
        index.registerInstance(this, hostRef);
        this.productId = undefined;
        this.value = undefined;
    }
    state() {
        return watchers.state[this.productId];
    }
    updateState(data) {
        watchers.state[this.productId] = {
            ...watchers.state[this.productId],
            ...data,
        };
    }
    render() {
        var _a, _b, _c, _d, _e, _f, _g, _h, _j, _k;
        const checked = !!((_a = this.state()) === null || _a === void 0 ? void 0 : _a.custom_amount);
        return (index.h(index.Host, { key: '7a9b7f513d19b5dfa61fe1199c36ff8af9310e25', class: { 'sc-product-donation-custom-amount': true, 'sc-product-donation-custom-amount--has-value': !!this.value } }, index.h("sc-choice-container", { key: '053018bee56a379f1fafd534d4ccfb26317d866b', value: `${(_b = this.state()) === null || _b === void 0 ? void 0 : _b.custom_amount}`, "show-control": "false", checked: checked, onClick: () => this.priceInput.triggerFocus(), onKeyDown: () => {
                this.priceInput.triggerFocus();
            }, role: "button" }, index.h("sc-visually-hidden", { key: '65639092b47669fa4102de1dd3f9985917ed6381' }, wp.i18n.__('Enter a custom amount.', 'surecart')), index.h("sc-price-input", { key: 'c985e5cfed51496288adb2763d12be39e857f67b', ref: el => (this.priceInput = el), currencyCode: ((_d = (_c = this.state()) === null || _c === void 0 ? void 0 : _c.selectedPrice) === null || _d === void 0 ? void 0 : _d.currency) || ((_e = window === null || window === void 0 ? void 0 : window.scData) === null || _e === void 0 ? void 0 : _e.currency) || 'usd', showCode: false, showLabel: false, value: `${((_f = this.state()) === null || _f === void 0 ? void 0 : _f.custom_amount) || ''}`, onScChange: e => this.updateState({
                ad_hoc_amount: null,
                custom_amount: e.target.value,
            }), min: (_h = (_g = this.state()) === null || _g === void 0 ? void 0 : _g.selectedPrice) === null || _h === void 0 ? void 0 : _h.ad_hoc_min_amount, max: (_k = (_j = this.state()) === null || _j === void 0 ? void 0 : _j.selectedPrice) === null || _k === void 0 ? void 0 : _k.ad_hoc_max_amount, style: { '--sc-input-border-color-focus': 'var(--sc-input-border-color-hover)', '--sc-focus-ring-color-primary': 'transparent' } }))));
    }
    get el() { return index.getElement(this); }
};
ScProductDonationCustomAmount.style = ScProductDonationCustomAmountStyle0;

exports.sc_product_donation_custom_amount = ScProductDonationCustomAmount;

//# sourceMappingURL=sc-product-donation-custom-amount.cjs.entry.js.map