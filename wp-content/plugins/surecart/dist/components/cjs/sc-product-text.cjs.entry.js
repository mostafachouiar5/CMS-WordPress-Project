'use strict';

Object.defineProperty(exports, '__esModule', { value: true });

const index = require('./index-8acc3c89.js');
const watchers = require('./watchers-cb566474.js');
require('./index-bcdafe6e.js');
require('./google-03835677.js');
require('./currency-71fce0f0.js');
require('./google-59d23803.js');
require('./utils-ee1bb9d3.js');
require('./util-b877b2bd.js');
require('./index-fb76df07.js');

const scProductTextCss = ":host{display:block}p{margin-block-start:0;margin-block-end:1em}";
const ScProductTextStyle0 = scProductTextCss;

const ScProductText = class {
    constructor(hostRef) {
        index.registerInstance(this, hostRef);
        this.text = 'name';
        this.productId = undefined;
    }
    render() {
        var _a;
        const product = (_a = watchers.state[this.productId]) === null || _a === void 0 ? void 0 : _a.product;
        if (product === null || product === void 0 ? void 0 : product[this.text]) {
            return index.h("span", { style: { whiteSpace: 'pre-line' }, innerHTML: product[this.text] });
        }
        return (index.h(index.Host, null, index.h("slot", null)));
    }
};
ScProductText.style = ScProductTextStyle0;

exports.sc_product_text = ScProductText;

//# sourceMappingURL=sc-product-text.cjs.entry.js.map