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

const scProductDonationChoicesCss = ":host{display:block}.sc-product-donation-choices{display:grid;gap:2em;position:relative;--columns:4}.sc-product-donation-choices__form{display:grid;gap:var(--sc-spacing-small)}.sc-donation-recurring-choices{display:grid;gap:var(--sc-spacing-small);position:relative;--columns:2}";
const ScProductDonationChoicesStyle0 = scProductDonationChoicesCss;

const ScProductDonationChoice = class {
    constructor(hostRef) {
        index.registerInstance(this, hostRef);
        this.productId = undefined;
        this.label = undefined;
        this.recurring = undefined;
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
        var _a, _b, _c, _d;
        const prices = (((_c = (_b = (_a = this.state()) === null || _a === void 0 ? void 0 : _a.product) === null || _b === void 0 ? void 0 : _b.prices) === null || _c === void 0 ? void 0 : _c.data) || [])
            .filter(price => (this.recurring ? (price === null || price === void 0 ? void 0 : price.recurring_interval) && (price === null || price === void 0 ? void 0 : price.ad_hoc) : !(price === null || price === void 0 ? void 0 : price.recurring_interval) && (price === null || price === void 0 ? void 0 : price.ad_hoc)))
            .filter(price => !(price === null || price === void 0 ? void 0 : price.archived));
        // no prices, or less than 2 prices, we have no choices.
        if (!(prices === null || prices === void 0 ? void 0 : prices.length)) {
            return index.h(index.Host, { style: { display: 'none' } });
        }
        // return price choice container.
        return (index.h("sc-recurring-price-choice-container", { prices: prices.sort((a, b) => (a === null || a === void 0 ? void 0 : a.position) - (b === null || b === void 0 ? void 0 : b.position)), product: (_d = this.state()) === null || _d === void 0 ? void 0 : _d.product, selectedPrice: this.state().selectedPrice, showDetails: false, showAmount: false, onScChange: e => {
                var _a, _b;
                const selectedPrice = (((_b = (_a = this.state().product) === null || _a === void 0 ? void 0 : _a.prices) === null || _b === void 0 ? void 0 : _b.data) || []).find(({ id }) => id == e.detail);
                this.updateState({ selectedPrice });
            }, "aria-label": this.recurring
                ? wp.i18n.__('If you want to make your donation recurring then Press Tab once & select the recurring interval from the dropdown. ', 'surecart')
                : wp.i18n.__('If you want to make your donation once then Press Enter. ', 'surecart'), style: { '--sc-recurring-price-choice-white-space': 'wrap', '--sc-recurring-price-choice-text-align': 'left' } }, index.h("slot", null, this.label)));
    }
    get el() { return index.getElement(this); }
};
ScProductDonationChoice.style = ScProductDonationChoicesStyle0;

exports.sc_product_donation_choices = ScProductDonationChoice;

//# sourceMappingURL=sc-product-donation-choices.cjs.entry.js.map