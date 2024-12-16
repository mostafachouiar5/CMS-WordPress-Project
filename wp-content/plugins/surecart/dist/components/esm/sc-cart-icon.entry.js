import { r as registerInstance, h } from './index-745b6bec.js';
import { a as store, s as state } from './mutations-d5e8faea.js';
import './index-06061d4e.js';
import './utils-e9ee502a.js';
import './remove-query-args-938c53ea.js';
import './add-query-args-0e2a8393.js';
import './index-c5a96d53.js';
import './google-a86aa761.js';
import './currency-a0c9bff4.js';
import './store-7020541e.js';
import './price-d5770168.js';

const scCartIconCss = ":host{display:block;--focus-ring:0 0 0 var(--sc-focus-ring-width) var(--sc-focus-ring-color-primary)}:host:focus-visible .cart{box-shadow:var(--focus-ring)}.cart{position:fixed;bottom:var(--sc-cart-icon-bottom, 30px);right:var(--sc-cart-icon-right, 30px);left:var(--sc-cart-icon-left, auto);top:var(--sc-cart-icon-top, auto);background:var(--sc-cart-icon-background, var(--sc-color-primary-500));border-radius:var(--sc-cart-icon-border-radius, var(--sc-input-border-radius-medium));width:var(--sc-cart-icon-width, 60px);height:var(--sc-cart-icon-height, 60px);color:var(--sc-cart-icon-color, var(--sc-color-primary-text, var(--sc-color-white)));font-family:var(--sc-cart-font-family, var(--sc-input-font-family));font-weight:var(--sc-font-weight-semibold);transition:opacity var(--sc-transition-medium) ease;box-shadow:var(--sc-shadow-small);cursor:pointer}.cart:hover{opacity:0.8}.cart__container{font-size:24px;position:relative;display:flex;align-items:center;justify-content:center;text-align:center;height:100%}.cart__counter{position:absolute;top:-8px;left:auto;bottom:auto;right:-8px;font-size:12px;border-radius:var(--sc-cart-counter-border-radius, 9999px);color:var(--sc-cart-counter-color, var(--sc-color-white));background:var(--sc-cart-counter-background, var(--sc-color-gray-900));box-shadow:var(--sc-cart-icon-box-shadow, var(--sc-shadow-x-large));padding:4px 10px;line-height:18px;z-index:1}";
const ScCartIconStyle0 = scCartIconCss;

const ScCartIcon = class {
    constructor(hostRef) {
        registerInstance(this, hostRef);
        this.icon = 'shopping-bag';
    }
    /** Count the number of items in the cart. */
    getItemsCount() {
        var _a, _b;
        const items = (_b = (_a = state === null || state === void 0 ? void 0 : state.checkout) === null || _a === void 0 ? void 0 : _a.line_items) === null || _b === void 0 ? void 0 : _b.data;
        let count = 0;
        (items || []).forEach(item => {
            count = count + (item === null || item === void 0 ? void 0 : item.quantity);
        });
        return count;
    }
    /** Toggle the cart in the ui. */
    toggleCart() {
        return store.set('cart', { ...store.state.cart, ...{ open: !store.state.cart.open } });
    }
    render() {
        var _a, _b, _c;
        if (!(state === null || state === void 0 ? void 0 : state.checkout) || ((_c = (_b = (_a = state === null || state === void 0 ? void 0 : state.checkout) === null || _a === void 0 ? void 0 : _a.line_items) === null || _b === void 0 ? void 0 : _b.data) === null || _c === void 0 ? void 0 : _c.length) === 0) {
            return null;
        }
        return (h("div", { class: {
                cart: true,
            }, part: "base", onClick: () => this.toggleCart(), onKeyDown: e => {
                if ('Enter' === (e === null || e === void 0 ? void 0 : e.code) || 'Space' === (e === null || e === void 0 ? void 0 : e.code)) {
                    this.toggleCart();
                    e.preventDefault();
                }
            }, tabIndex: 0, role: "button", "aria-label": !store.state.cart.open ? wp.i18n.sprintf(wp.i18n.__('Open Cart Floating Icon with %d items', 'surecart'), this.getItemsCount()) : wp.i18n.__('Close Cart Floating Icon', 'surecart') }, h("div", { class: "cart__container", part: "container" }, h("div", { class: { cart__counter: true } }, this.getItemsCount()), h("slot", null, h("sc-icon", { exportparts: "base:icon__base", name: this.icon })))));
    }
};
ScCartIcon.style = ScCartIconStyle0;

export { ScCartIcon as sc_cart_icon };

//# sourceMappingURL=sc-cart-icon.entry.js.map