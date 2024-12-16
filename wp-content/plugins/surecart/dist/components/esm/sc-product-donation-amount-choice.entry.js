import { r as registerInstance, h, a as getElement, H as Host } from './index-745b6bec.js';
import { i as isInRange } from './util-50af2a83.js';
import { s as state, c as getInRangeAmounts, u as updateDonationState } from './watchers-bbcb6e4d.js';
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
import './mutations-01792dfb.js';
import './mutations-ed6d0770.js';
import './index-96490395.js';
import './fetch-2032d11d.js';

const scProductDonationAmountChoiceCss = "";
const ScProductDonationAmountChoiceStyle0 = scProductDonationAmountChoiceCss;

const ScProductDonationAmountChoice = class {
    constructor(hostRef) {
        registerInstance(this, hostRef);
        this.productId = undefined;
        this.value = undefined;
        this.label = undefined;
    }
    state() {
        return state[this.productId];
    }
    render() {
        var _a;
        const amounts = getInRangeAmounts(this.productId);
        const order = amounts.indexOf(this.value);
        if (!isInRange(this.value, this.state().selectedPrice) || order < 0)
            return h(Host, { style: { display: 'none' } });
        return (h("sc-choice-container", { "show-control": "false", checked: this.state().ad_hoc_amount === this.value, onScChange: () => updateDonationState(this.productId, { ad_hoc_amount: this.value, custom_amount: null }), "aria-label": wp.i18n.sprintf(wp.i18n.__('%d of %d', 'surecart'), order + 1, amounts.length), role: "button" }, this.label ? (this.label) : (h("sc-format-number", { type: "currency", currency: (_a = this.state().selectedPrice) === null || _a === void 0 ? void 0 : _a.currency, value: this.value, "minimum-fraction-digits": "0" }))));
    }
    get el() { return getElement(this); }
};
ScProductDonationAmountChoice.style = ScProductDonationAmountChoiceStyle0;

export { ScProductDonationAmountChoice as sc_product_donation_amount_choice };

//# sourceMappingURL=sc-product-donation-amount-choice.entry.js.map