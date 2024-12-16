import { r as registerInstance, c as createEvent, h } from './index-745b6bec.js';
import { s as state } from './mutations-d5e8faea.js';
import './index-06061d4e.js';
import './utils-e9ee502a.js';
import './remove-query-args-938c53ea.js';
import './add-query-args-0e2a8393.js';
import './index-c5a96d53.js';
import './google-a86aa761.js';
import './currency-a0c9bff4.js';
import './store-7020541e.js';
import './price-d5770168.js';

const scCartHeaderCss = ".cart-header{display:flex;align-items:center;justify-content:space-between;width:100%;font-size:1em}.cart-title{text-align:center;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;padding:0 var(--sc-spacing-small)}.cart__close{cursor:pointer}";
const ScCartHeaderStyle0 = scCartHeaderCss;

const ScCartHeader = class {
    constructor(hostRef) {
        registerInstance(this, hostRef);
        this.scCloseCart = createEvent(this, "scCloseCart", 7);
    }
    /** Count the number of items in the cart. */
    getItemsCount() {
        var _a, _b;
        const items = ((_b = (_a = state.checkout) === null || _a === void 0 ? void 0 : _a.line_items) === null || _b === void 0 ? void 0 : _b.data) || [];
        let count = 0;
        items.forEach(item => {
            count = count + (item === null || item === void 0 ? void 0 : item.quantity);
        });
        return count;
    }
    render() {
        var _a;
        return (h("div", { key: 'a98d0178e7cee53855de66b2b8a482a7b3979b4f', class: "cart-header" }, h("sc-icon", { key: '6d033a04e5bf15426db6bf0209adb82fc24f3518', class: "cart__close", name: "arrow-right", onClick: () => this.scCloseCart.emit(), onKeyDown: e => {
                if ('Enter' === (e === null || e === void 0 ? void 0 : e.code) || 'Space' === (e === null || e === void 0 ? void 0 : e.code)) {
                    this.scCloseCart.emit();
                }
            }, tabIndex: 0, role: "button", "aria-label": wp.i18n.__('Close Cart', 'surecart') }), h("div", { key: '2fc4b580ae472ff20329a16a76a5d35090891c6e', class: "cart-title" }, h("slot", { key: 'f24d357acfa1ac9c5fa5c6382790c1c74f31d3d9' })), h("sc-tag", { key: '13ae05191d43b57a126fe93df4b520cd6c34f082', size: "small" }, ((_a = this === null || this === void 0 ? void 0 : this.getItemsCount) === null || _a === void 0 ? void 0 : _a.call(this)) || 0)));
    }
};
ScCartHeader.style = ScCartHeaderStyle0;

export { ScCartHeader as sc_cart_header };

//# sourceMappingURL=sc-cart-header.entry.js.map