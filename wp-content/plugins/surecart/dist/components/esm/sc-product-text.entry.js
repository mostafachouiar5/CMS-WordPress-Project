import { r as registerInstance, h, H as Host } from './index-745b6bec.js';
import { s as state } from './watchers-67501779.js';
import './index-06061d4e.js';
import './google-dd89f242.js';
import './currency-a0c9bff4.js';
import './google-a86aa761.js';
import './utils-e9ee502a.js';
import './util-50af2a83.js';
import './index-c5a96d53.js';

const scProductTextCss = ":host{display:block}p{margin-block-start:0;margin-block-end:1em}";
const ScProductTextStyle0 = scProductTextCss;

const ScProductText = class {
    constructor(hostRef) {
        registerInstance(this, hostRef);
        this.text = 'name';
        this.productId = undefined;
    }
    render() {
        var _a;
        const product = (_a = state[this.productId]) === null || _a === void 0 ? void 0 : _a.product;
        if (product === null || product === void 0 ? void 0 : product[this.text]) {
            return h("span", { style: { whiteSpace: 'pre-line' }, innerHTML: product[this.text] });
        }
        return (h(Host, null, h("slot", null)));
    }
};
ScProductText.style = ScProductTextStyle0;

export { ScProductText as sc_product_text };

//# sourceMappingURL=sc-product-text.entry.js.map