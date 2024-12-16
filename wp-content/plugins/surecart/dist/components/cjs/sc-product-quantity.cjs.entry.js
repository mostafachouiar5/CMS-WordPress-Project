'use strict';

Object.defineProperty(exports, '__esModule', { value: true });

const index = require('./index-8acc3c89.js');
const watchers = require('./watchers-cb566474.js');
const quantity = require('./quantity-bff7f892.js');
require('./index-bcdafe6e.js');
require('./google-03835677.js');
require('./currency-71fce0f0.js');
require('./google-59d23803.js');
require('./utils-ee1bb9d3.js');
require('./util-b877b2bd.js');
require('./index-fb76df07.js');

const scProductQuantityCss = ":host{display:block}";
const ScProductQuantityStyle0 = scProductQuantityCss;

let id = 0;
const ScProductQuantity = class {
    constructor(hostRef) {
        index.registerInstance(this, hostRef);
        this.inputId = `sc-quantity-${++id}`;
        this.helpId = `sc-quantity-help-text-${id}`;
        this.labelId = `sc-quantity-label-${id}`;
        this.size = 'medium';
        this.name = undefined;
        this.errors = undefined;
        this.showLabel = true;
        this.label = undefined;
        this.required = false;
        this.help = undefined;
        this.productId = undefined;
    }
    render() {
        var _a, _b, _c, _d, _e, _f, _g;
        const maxStockQuantity = quantity.getMaxStockQuantity((_a = watchers.state[this.productId]) === null || _a === void 0 ? void 0 : _a.product, (_b = watchers.state[this.productId]) === null || _b === void 0 ? void 0 : _b.selectedVariant);
        return (index.h(index.Host, { key: '7ce131521009ff58c7848c6f6b8fae90507ef2f3' }, index.h("sc-form-control", { key: 'cc0899d4af6fec59da9da041b4ae9499a5d49f56', exportparts: "label, help-text, form-control", size: this.size, required: this.required, label: this.label, showLabel: this.showLabel, help: this.help, inputId: this.inputId, helpId: this.helpId, labelId: this.labelId, name: this.name }, index.h("sc-quantity-select", { key: '7f54bb234abe657869d19fd3fe8ea69470f2f28e', size: this.size, quantity: Math.max(((_d = (_c = watchers.state[this.productId]) === null || _c === void 0 ? void 0 : _c.selectedPrice) === null || _d === void 0 ? void 0 : _d.ad_hoc) ? 1 : (_e = watchers.state[this.productId]) === null || _e === void 0 ? void 0 : _e.quantity, 1), disabled: (_g = (_f = watchers.state[this.productId]) === null || _f === void 0 ? void 0 : _f.selectedPrice) === null || _g === void 0 ? void 0 : _g.ad_hoc, onScInput: e => watchers.setProduct(this.productId, { quantity: e.detail }), ...(!!maxStockQuantity ? { max: maxStockQuantity } : {}) }))));
    }
};
ScProductQuantity.style = ScProductQuantityStyle0;

exports.sc_product_quantity = ScProductQuantity;

//# sourceMappingURL=sc-product-quantity.cjs.entry.js.map