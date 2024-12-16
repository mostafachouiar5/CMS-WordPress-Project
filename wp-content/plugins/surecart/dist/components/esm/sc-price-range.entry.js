import { r as registerInstance, h, H as Host } from './index-745b6bec.js';

const scPriceRangeCss = ":host{display:block;line-height:1}";
const ScPriceRangeStyle0 = scPriceRangeCss;

const ScPriceRange = class {
    constructor(hostRef) {
        registerInstance(this, hostRef);
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
            return h(Host, null);
        }
        return (h(Host, null, this.maxPrice.amount == this.minPrice.amount ? (h("span", null, h("sc-format-number", { type: "currency", currency: this.maxPrice.currency, value: this.maxPrice.amount }))) : (h("span", null, h("sc-visually-hidden", null, wp.i18n.__('Price range from', 'surecart'), " "), h("sc-format-number", { type: "currency", currency: this.minPrice.currency, value: this.minPrice.amount }), h("span", { "aria-hidden": true }, ' — '), h("sc-visually-hidden", null, wp.i18n.__('to', 'surecart')), h("sc-format-number", { type: "currency", currency: this.maxPrice.currency, value: this.maxPrice.amount })))));
    }
    static get watchers() { return {
        "prices": ["handlePricesChange"]
    }; }
};
ScPriceRange.style = ScPriceRangeStyle0;

export { ScPriceRange as sc_price_range };

//# sourceMappingURL=sc-price-range.entry.js.map