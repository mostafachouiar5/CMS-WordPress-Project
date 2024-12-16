import { r as registerInstance, h, H as Host } from './index-745b6bec.js';
import { s as state } from './watchers-67501779.js';
import { a as getDiscountedAmount, b as getScratchAmount } from './getters-b1d93841.js';
import './index-06061d4e.js';
import './google-dd89f242.js';
import './currency-a0c9bff4.js';
import './google-a86aa761.js';
import './utils-e9ee502a.js';
import './util-50af2a83.js';
import './index-c5a96d53.js';
import './store-dcefd119.js';

const scProductPriceCss = ":host{display:block}";
const ScProductPriceStyle0 = scProductPriceCss;

const ScProductPrice = class {
    constructor(hostRef) {
        registerInstance(this, hostRef);
        this.prices = undefined;
        this.saleText = undefined;
        this.productId = undefined;
    }
    renderRange() {
        var _a, _b, _c, _d;
        if (((_b = (_a = state[this.productId]) === null || _a === void 0 ? void 0 : _a.prices) === null || _b === void 0 ? void 0 : _b.length) === 1) {
            return this.renderPrice((_c = state[this.productId]) === null || _c === void 0 ? void 0 : _c.prices[0]);
        }
        return h("sc-price-range", { prices: (_d = state[this.productId]) === null || _d === void 0 ? void 0 : _d.prices });
    }
    renderVariantPrice(selectedVariant) {
        var _a, _b;
        const variant = (_b = (_a = state[this.productId]) === null || _a === void 0 ? void 0 : _a.variants) === null || _b === void 0 ? void 0 : _b.find(variant => (variant === null || variant === void 0 ? void 0 : variant.id) === (selectedVariant === null || selectedVariant === void 0 ? void 0 : selectedVariant.id));
        return this.renderPrice(state[this.productId].selectedPrice, variant === null || variant === void 0 ? void 0 : variant.amount);
    }
    renderPrice(price, variantAmount) {
        var _a;
        const originalAmount = (_a = variantAmount !== null && variantAmount !== void 0 ? variantAmount : price === null || price === void 0 ? void 0 : price.amount) !== null && _a !== void 0 ? _a : 0;
        const amount = getDiscountedAmount(originalAmount);
        const scratch_amount = getScratchAmount(price === null || price === void 0 ? void 0 : price.scratch_amount);
        return (h("sc-price", { currency: price === null || price === void 0 ? void 0 : price.currency, amount: amount, scratchAmount: scratch_amount, saleText: this.saleText, adHoc: price === null || price === void 0 ? void 0 : price.ad_hoc, trialDurationDays: price === null || price === void 0 ? void 0 : price.trial_duration_days, setupFeeAmount: (price === null || price === void 0 ? void 0 : price.setup_fee_enabled) ? price === null || price === void 0 ? void 0 : price.setup_fee_amount : null, setupFeeName: (price === null || price === void 0 ? void 0 : price.setup_fee_enabled) ? price === null || price === void 0 ? void 0 : price.setup_fee_name : null, recurringPeriodCount: price === null || price === void 0 ? void 0 : price.recurring_period_count, recurringInterval: price === null || price === void 0 ? void 0 : price.recurring_interval, recurringIntervalCount: price === null || price === void 0 ? void 0 : price.recurring_interval_count }));
    }
    render() {
        return (h(Host, { key: '65a82c5bf3f74a35708473f60884739ea12b66a1', role: "paragraph" }, (() => {
            var _a, _b, _c, _d, _e;
            if ((_a = state[this.productId]) === null || _a === void 0 ? void 0 : _a.selectedVariant) {
                return this.renderVariantPrice((_b = state[this.productId]) === null || _b === void 0 ? void 0 : _b.selectedVariant);
            }
            if ((_c = state[this.productId]) === null || _c === void 0 ? void 0 : _c.selectedPrice) {
                return this.renderPrice(state[this.productId].selectedPrice);
            }
            if ((_e = (_d = state[this.productId]) === null || _d === void 0 ? void 0 : _d.prices) === null || _e === void 0 ? void 0 : _e.length) {
                return this.renderRange();
            }
            return h("slot", null);
        })()));
    }
};
ScProductPrice.style = ScProductPriceStyle0;

export { ScProductPrice as sc_product_price };

//# sourceMappingURL=sc-product-price.entry.js.map