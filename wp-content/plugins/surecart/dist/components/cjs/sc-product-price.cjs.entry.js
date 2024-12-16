'use strict';

Object.defineProperty(exports, '__esModule', { value: true });

const index = require('./index-8acc3c89.js');
const watchers = require('./watchers-cb566474.js');
const getters = require('./getters-f6bbfe30.js');
require('./index-bcdafe6e.js');
require('./google-03835677.js');
require('./currency-71fce0f0.js');
require('./google-59d23803.js');
require('./utils-ee1bb9d3.js');
require('./util-b877b2bd.js');
require('./index-fb76df07.js');
require('./store-d24717c6.js');

const scProductPriceCss = ":host{display:block}";
const ScProductPriceStyle0 = scProductPriceCss;

const ScProductPrice = class {
    constructor(hostRef) {
        index.registerInstance(this, hostRef);
        this.prices = undefined;
        this.saleText = undefined;
        this.productId = undefined;
    }
    renderRange() {
        var _a, _b, _c, _d;
        if (((_b = (_a = watchers.state[this.productId]) === null || _a === void 0 ? void 0 : _a.prices) === null || _b === void 0 ? void 0 : _b.length) === 1) {
            return this.renderPrice((_c = watchers.state[this.productId]) === null || _c === void 0 ? void 0 : _c.prices[0]);
        }
        return index.h("sc-price-range", { prices: (_d = watchers.state[this.productId]) === null || _d === void 0 ? void 0 : _d.prices });
    }
    renderVariantPrice(selectedVariant) {
        var _a, _b;
        const variant = (_b = (_a = watchers.state[this.productId]) === null || _a === void 0 ? void 0 : _a.variants) === null || _b === void 0 ? void 0 : _b.find(variant => (variant === null || variant === void 0 ? void 0 : variant.id) === (selectedVariant === null || selectedVariant === void 0 ? void 0 : selectedVariant.id));
        return this.renderPrice(watchers.state[this.productId].selectedPrice, variant === null || variant === void 0 ? void 0 : variant.amount);
    }
    renderPrice(price, variantAmount) {
        var _a;
        const originalAmount = (_a = variantAmount !== null && variantAmount !== void 0 ? variantAmount : price === null || price === void 0 ? void 0 : price.amount) !== null && _a !== void 0 ? _a : 0;
        const amount = getters.getDiscountedAmount(originalAmount);
        const scratch_amount = getters.getScratchAmount(price === null || price === void 0 ? void 0 : price.scratch_amount);
        return (index.h("sc-price", { currency: price === null || price === void 0 ? void 0 : price.currency, amount: amount, scratchAmount: scratch_amount, saleText: this.saleText, adHoc: price === null || price === void 0 ? void 0 : price.ad_hoc, trialDurationDays: price === null || price === void 0 ? void 0 : price.trial_duration_days, setupFeeAmount: (price === null || price === void 0 ? void 0 : price.setup_fee_enabled) ? price === null || price === void 0 ? void 0 : price.setup_fee_amount : null, setupFeeName: (price === null || price === void 0 ? void 0 : price.setup_fee_enabled) ? price === null || price === void 0 ? void 0 : price.setup_fee_name : null, recurringPeriodCount: price === null || price === void 0 ? void 0 : price.recurring_period_count, recurringInterval: price === null || price === void 0 ? void 0 : price.recurring_interval, recurringIntervalCount: price === null || price === void 0 ? void 0 : price.recurring_interval_count }));
    }
    render() {
        return (index.h(index.Host, { key: '65a82c5bf3f74a35708473f60884739ea12b66a1', role: "paragraph" }, (() => {
            var _a, _b, _c, _d, _e;
            if ((_a = watchers.state[this.productId]) === null || _a === void 0 ? void 0 : _a.selectedVariant) {
                return this.renderVariantPrice((_b = watchers.state[this.productId]) === null || _b === void 0 ? void 0 : _b.selectedVariant);
            }
            if ((_c = watchers.state[this.productId]) === null || _c === void 0 ? void 0 : _c.selectedPrice) {
                return this.renderPrice(watchers.state[this.productId].selectedPrice);
            }
            if ((_e = (_d = watchers.state[this.productId]) === null || _d === void 0 ? void 0 : _d.prices) === null || _e === void 0 ? void 0 : _e.length) {
                return this.renderRange();
            }
            return index.h("slot", null);
        })()));
    }
};
ScProductPrice.style = ScProductPriceStyle0;

exports.sc_product_price = ScProductPrice;

//# sourceMappingURL=sc-product-price.cjs.entry.js.map