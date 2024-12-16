'use strict';

Object.defineProperty(exports, '__esModule', { value: true });

const index = require('./index-8acc3c89.js');

const scPriceRangeCss = ":host{display:block;line-height:1}";
const ScPriceRangeStyle0 = scPriceRangeCss;

const ScPriceRange = class {
    constructor(hostRef) {
        index.registerInstance(this, hostRef);
        this.prices = undefined;
        this.minPrice = undefined;
        this.maxPrice = undefined;
    }
    handlePricesChange() {
        let min, max;
        (this.prices || [])
            .filter(p => !(p === null || p === void 0 ? void 0 : p.archived))
            .forEach(price => {
            if (!max || price.amount > max.amount) {
                max = price;
            }
            if (!min || price.amount < min.amount) {
                min = price;
            }
        });
        this.minPrice = min;
        this.maxPrice = max;
    }
    componentWillLoad() {
        this.handlePricesChange();
    }
    render() {
        if (!this.maxPrice || !this.minPrice) {
            return index.h(index.Host, null);
        }
        return (index.h(index.Host, null, this.maxPrice.amount == this.minPrice.amount ? (index.h("span", null, index.h("sc-format-number", { type: "currency", currency: this.maxPrice.currency, value: this.maxPrice.amount }))) : (index.h("span", null, index.h("sc-visually-hidden", null, wp.i18n.__('Price range from', 'surecart'), " "), index.h("sc-format-number", { type: "currency", currency: this.minPrice.currency, value: this.minPrice.amount }), index.h("span", { "aria-hidden": true }, ' — '), index.h("sc-visually-hidden", null, wp.i18n.__('to', 'surecart')), index.h("sc-format-number", { type: "currency", currency: this.maxPrice.currency, value: this.maxPrice.amount })))));
    }
    static get watchers() { return {
        "prices": ["handlePricesChange"]
    }; }
};
ScPriceRange.style = ScPriceRangeStyle0;

exports.sc_price_range = ScPriceRange;

//# sourceMappingURL=sc-price-range.cjs.entry.js.map