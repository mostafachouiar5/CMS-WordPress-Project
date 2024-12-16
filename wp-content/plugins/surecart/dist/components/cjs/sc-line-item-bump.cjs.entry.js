'use strict';

Object.defineProperty(exports, '__esModule', { value: true });

const index = require('./index-8acc3c89.js');
const mutations = require('./mutations-19357660.js');
require('./index-bcdafe6e.js');
require('./utils-ee1bb9d3.js');
require('./remove-query-args-b57e8cd3.js');
require('./add-query-args-49dcb630.js');
require('./index-fb76df07.js');
require('./google-59d23803.js');
require('./currency-71fce0f0.js');
require('./store-1fb3d249.js');
require('./price-653ec1cb.js');

const scLineItemBumpCss = ":host{display:block}";
const ScLineItemBumpStyle0 = scLineItemBumpCss;

const ScLineItemBump = class {
    constructor(hostRef) {
        index.registerInstance(this, hostRef);
        this.label = undefined;
        this.loading = undefined;
    }
    render() {
        var _a, _b, _c;
        if (!((_a = mutations.state === null || mutations.state === void 0 ? void 0 : mutations.state.checkout) === null || _a === void 0 ? void 0 : _a.bump_amount)) {
            return index.h(index.Host, { style: { display: 'none' } });
        }
        return (index.h("sc-line-item", null, index.h("span", { slot: "description" }, this.label || wp.i18n.__('Bundle Discount', 'surecart')), index.h("span", { slot: "price" }, index.h("sc-format-number", { type: "currency", currency: ((_b = mutations.state === null || mutations.state === void 0 ? void 0 : mutations.state.checkout) === null || _b === void 0 ? void 0 : _b.currency) || 'usd', value: (_c = mutations.state === null || mutations.state === void 0 ? void 0 : mutations.state.checkout) === null || _c === void 0 ? void 0 : _c.bump_amount }))));
    }
};
ScLineItemBump.style = ScLineItemBumpStyle0;

exports.sc_line_item_bump = ScLineItemBump;

//# sourceMappingURL=sc-line-item-bump.cjs.entry.js.map