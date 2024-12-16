import { r as registerInstance, h, H as Host } from './index-745b6bec.js';
import { s as state, b as setProduct } from './watchers-67501779.js';
import { g as getMaxStockQuantity } from './quantity-1f39f750.js';
import './index-06061d4e.js';
import './google-dd89f242.js';
import './currency-a0c9bff4.js';
import './google-a86aa761.js';
import './utils-e9ee502a.js';
import './util-50af2a83.js';
import './index-c5a96d53.js';

const scProductQuantityCss = ":host{display:block}";
const ScProductQuantityStyle0 = scProductQuantityCss;

let id = 0;
const ScProductQuantity = class {
    constructor(hostRef) {
        registerInstance(this, hostRef);
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
        const maxStockQuantity = getMaxStockQuantity((_a = state[this.productId]) === null || _a === void 0 ? void 0 : _a.product, (_b = state[this.productId]) === null || _b === void 0 ? void 0 : _b.selectedVariant);
        return (h(Host, { key: '7ce131521009ff58c7848c6f6b8fae90507ef2f3' }, h("sc-form-control", { key: 'cc0899d4af6fec59da9da041b4ae9499a5d49f56', exportparts: "label, help-text, form-control", size: this.size, required: this.required, label: this.label, showLabel: this.showLabel, help: this.help, inputId: this.inputId, helpId: this.helpId, labelId: this.labelId, name: this.name }, h("sc-quantity-select", { key: '7f54bb234abe657869d19fd3fe8ea69470f2f28e', size: this.size, quantity: Math.max(((_d = (_c = state[this.productId]) === null || _c === void 0 ? void 0 : _c.selectedPrice) === null || _d === void 0 ? void 0 : _d.ad_hoc) ? 1 : (_e = state[this.productId]) === null || _e === void 0 ? void 0 : _e.quantity, 1), disabled: (_g = (_f = state[this.productId]) === null || _f === void 0 ? void 0 : _f.selectedPrice) === null || _g === void 0 ? void 0 : _g.ad_hoc, onScInput: e => setProduct(this.productId, { quantity: e.detail }), ...(!!maxStockQuantity ? { max: maxStockQuantity } : {}) }))));
    }
};
ScProductQuantity.style = ScProductQuantityStyle0;

export { ScProductQuantity as sc_product_quantity };

//# sourceMappingURL=sc-product-quantity.entry.js.map