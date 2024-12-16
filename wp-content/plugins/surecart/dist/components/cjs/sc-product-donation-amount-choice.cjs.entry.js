'use strict';

Object.defineProperty(exports, '__esModule', { value: true });

const index = require('./index-8acc3c89.js');
const util = require('./util-b877b2bd.js');
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
require('./mutations-6484d4a1.js');
require('./mutations-11c8f9a8.js');
require('./index-771f480e.js');
require('./fetch-f25a0cb0.js');

const scProductDonationAmountChoiceCss = "";
const ScProductDonationAmountChoiceStyle0 = scProductDonationAmountChoiceCss;

const ScProductDonationAmountChoice = class {
    constructor(hostRef) {
        index.registerInstance(this, hostRef);
        this.productId = undefined;
        this.value = undefined;
        this.label = undefined;
    }
    state() {
        return watchers.state[this.productId];
    }
    render() {
        var _a;
        const amounts = watchers.getInRangeAmounts(this.productId);
        const order = amounts.indexOf(this.value);
        if (!util.isInRange(this.value, this.state().selectedPrice) || order < 0)
            return index.h(index.Host, { style: { display: 'none' } });
        return (index.h("sc-choice-container", { "show-control": "false", checked: this.state().ad_hoc_amount === this.value, onScChange: () => watchers.updateDonationState(this.productId, { ad_hoc_amount: this.value, custom_amount: null }), "aria-label": wp.i18n.sprintf(wp.i18n.__('%d of %d', 'surecart'), order + 1, amounts.length), role: "button" }, this.label ? (this.label) : (index.h("sc-format-number", { type: "currency", currency: (_a = this.state().selectedPrice) === null || _a === void 0 ? void 0 : _a.currency, value: this.value, "minimum-fraction-digits": "0" }))));
    }
    get el() { return index.getElement(this); }
};
ScProductDonationAmountChoice.style = ScProductDonationAmountChoiceStyle0;

exports.sc_product_donation_amount_choice = ScProductDonationAmountChoice;

//# sourceMappingURL=sc-product-donation-amount-choice.cjs.entry.js.map