'use strict';

Object.defineProperty(exports, '__esModule', { value: true });

const index = require('./index-8acc3c89.js');
const price = require('./price-653ec1cb.js');
const watchers = require('./watchers-cb566474.js');
require('./currency-71fce0f0.js');
require('./index-bcdafe6e.js');
require('./google-03835677.js');
require('./google-59d23803.js');
require('./utils-ee1bb9d3.js');
require('./util-b877b2bd.js');
require('./index-fb76df07.js');

const scProductPriceChoicesCss = ":host{display:block;text-align:left;position:relative;z-index:1}";
const ScProductPriceChoicesStyle0 = scProductPriceChoicesCss;

const ScProductPriceChoices = class {
    constructor(hostRef) {
        index.registerInstance(this, hostRef);
        this.label = undefined;
        this.showPrice = undefined;
        this.productId = undefined;
    }
    renderPrice(price$1) {
        return (index.h(index.Fragment, null, index.h("sc-format-number", { type: "currency", value: price$1.amount, currency: price$1.currency }), index.h("span", { slot: "per" }, price.intervalString(price$1, {
            labels: {
                interval: wp.i18n.__('Every', 'surecart'),
                period: wp.i18n.__('for', 'surecart'),
                once: wp.i18n.__('Once', 'surecart'),
            },
            showOnce: true,
        }))));
    }
    render() {
        const prices = watchers.availablePrices(this.productId);
        if ((prices === null || prices === void 0 ? void 0 : prices.length) < 2)
            return index.h(index.Host, { style: { display: 'none' } });
        return (index.h("sc-choices", { label: this.label, required: true, style: { '--sc-input-required-indicator': ' ' } }, (prices || []).map(price => {
            var _a, _b, _c, _d;
            return (index.h("sc-price-choice-container", { label: (price === null || price === void 0 ? void 0 : price.name) || ((_b = (_a = watchers.state[this.productId]) === null || _a === void 0 ? void 0 : _a.product) === null || _b === void 0 ? void 0 : _b.name), showPrice: !!this.showPrice, price: price, checked: ((_d = (_c = watchers.state[this.productId]) === null || _c === void 0 ? void 0 : _c.selectedPrice) === null || _d === void 0 ? void 0 : _d.id) === (price === null || price === void 0 ? void 0 : price.id), onScChange: e => {
                    if (e.target.checked) {
                        watchers.setProduct(this.productId, { selectedPrice: price });
                    }
                } }));
        })));
    }
};
ScProductPriceChoices.style = ScProductPriceChoicesStyle0;

exports.sc_product_price_choices = ScProductPriceChoices;

//# sourceMappingURL=sc-product-price-choices.cjs.entry.js.map