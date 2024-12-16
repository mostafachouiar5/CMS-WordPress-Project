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

const scCartHeaderCss = ".cart-header{display:flex;align-items:center;justify-content:space-between;width:100%;font-size:1em}.cart-title{text-align:center;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;padding:0 var(--sc-spacing-small)}.cart__close{cursor:pointer}";
const ScCartHeaderStyle0 = scCartHeaderCss;

const ScCartHeader = class {
    constructor(hostRef) {
        index.registerInstance(this, hostRef);
        this.scCloseCart = index.createEvent(this, "scCloseCart", 7);
    }
    /** Count the number of items in the cart. */
    getItemsCount() {
        var _a, _b;
        const items = ((_b = (_a = mutations.state.checkout) === null || _a === void 0 ? void 0 : _a.line_items) === null || _b === void 0 ? void 0 : _b.data) || [];
        let count = 0;
        items.forEach(item => {
            count = count + (item === null || item === void 0 ? void 0 : item.quantity);
        });
        return count;
    }
    render() {
        var _a;
        return (index.h("div", { key: 'a98d0178e7cee53855de66b2b8a482a7b3979b4f', class: "cart-header" }, index.h("sc-icon", { key: '6d033a04e5bf15426db6bf0209adb82fc24f3518', class: "cart__close", name: "arrow-right", onClick: () => this.scCloseCart.emit(), onKeyDown: e => {
                if ('Enter' === (e === null || e === void 0 ? void 0 : e.code) || 'Space' === (e === null || e === void 0 ? void 0 : e.code)) {
                    this.scCloseCart.emit();
                }
            }, tabIndex: 0, role: "button", "aria-label": wp.i18n.__('Close Cart', 'surecart') }), index.h("div", { key: '2fc4b580ae472ff20329a16a76a5d35090891c6e', class: "cart-title" }, index.h("slot", { key: 'f24d357acfa1ac9c5fa5c6382790c1c74f31d3d9' })), index.h("sc-tag", { key: '13ae05191d43b57a126fe93df4b520cd6c34f082', size: "small" }, ((_a = this === null || this === void 0 ? void 0 : this.getItemsCount) === null || _a === void 0 ? void 0 : _a.call(this)) || 0)));
    }
};
ScCartHeader.style = ScCartHeaderStyle0;

exports.sc_cart_header = ScCartHeader;

//# sourceMappingURL=sc-cart-header.cjs.entry.js.map