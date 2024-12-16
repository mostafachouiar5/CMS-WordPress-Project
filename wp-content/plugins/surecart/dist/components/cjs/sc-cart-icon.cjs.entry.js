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

const scCartIconCss = ":host{display:block;--focus-ring:0 0 0 var(--sc-focus-ring-width) var(--sc-focus-ring-color-primary)}:host:focus-visible .cart{box-shadow:var(--focus-ring)}.cart{position:fixed;bottom:var(--sc-cart-icon-bottom, 30px);right:var(--sc-cart-icon-right, 30px);left:var(--sc-cart-icon-left, auto);top:var(--sc-cart-icon-top, auto);background:var(--sc-cart-icon-background, var(--sc-color-primary-500));border-radius:var(--sc-cart-icon-border-radius, var(--sc-input-border-radius-medium));width:var(--sc-cart-icon-width, 60px);height:var(--sc-cart-icon-height, 60px);color:var(--sc-cart-icon-color, var(--sc-color-primary-text, var(--sc-color-white)));font-family:var(--sc-cart-font-family, var(--sc-input-font-family));font-weight:var(--sc-font-weight-semibold);transition:opacity var(--sc-transition-medium) ease;box-shadow:var(--sc-shadow-small);cursor:pointer}.cart:hover{opacity:0.8}.cart__container{font-size:24px;position:relative;display:flex;align-items:center;justify-content:center;text-align:center;height:100%}.cart__counter{position:absolute;top:-8px;left:auto;bottom:auto;right:-8px;font-size:12px;border-radius:var(--sc-cart-counter-border-radius, 9999px);color:var(--sc-cart-counter-color, var(--sc-color-white));background:var(--sc-cart-counter-background, var(--sc-color-gray-900));box-shadow:var(--sc-cart-icon-box-shadow, var(--sc-shadow-x-large));padding:4px 10px;line-height:18px;z-index:1}";
const ScCartIconStyle0 = scCartIconCss;

const ScCartIcon = class {
    constructor(hostRef) {
        index.registerInstance(this, hostRef);
        this.icon = 'shopping-bag';
    }
    /** Count the number of items in the cart. */
    getItemsCount() {
        var _a, _b;
        const items = (_b = (_a = mutations.state === null || mutations.state === void 0 ? void 0 : mutations.state.checkout) === null || _a === void 0 ? void 0 : _a.line_items) === null || _b === void 0 ? void 0 : _b.data;
        let count = 0;
        (items || []).forEach(item => {
            count = count + (item === null || item === void 0 ? void 0 : item.quantity);
        });
        return count;
    }
    /** Toggle the cart in the ui. */
    toggleCart() {
        return mutations.store.set('cart', { ...mutations.store.state.cart, ...{ open: !mutations.store.state.cart.open } });
    }
    render() {
        var _a, _b, _c;
        if (!(mutations.state === null || mutations.state === void 0 ? void 0 : mutations.state.checkout) || ((_c = (_b = (_a = mutations.state === null || mutations.state === void 0 ? void 0 : mutations.state.checkout) === null || _a === void 0 ? void 0 : _a.line_items) === null || _b === void 0 ? void 0 : _b.data) === null || _c === void 0 ? void 0 : _c.length) === 0) {
            return null;
        }
        return (index.h("div", { class: {
                cart: true,
            }, part: "base", onClick: () => this.toggleCart(), onKeyDown: e => {
                if ('Enter' === (e === null || e === void 0 ? void 0 : e.code) || 'Space' === (e === null || e === void 0 ? void 0 : e.code)) {
                    this.toggleCart();
                    e.preventDefault();
                }
            }, tabIndex: 0, role: "button", "aria-label": !mutations.store.state.cart.open ? wp.i18n.sprintf(wp.i18n.__('Open Cart Floating Icon with %d items', 'surecart'), this.getItemsCount()) : wp.i18n.__('Close Cart Floating Icon', 'surecart') }, index.h("div", { class: "cart__container", part: "container" }, index.h("div", { class: { cart__counter: true } }, this.getItemsCount()), index.h("slot", null, index.h("sc-icon", { exportparts: "base:icon__base", name: this.icon })))));
    }
};
ScCartIcon.style = ScCartIconStyle0;

exports.sc_cart_icon = ScCartIcon;

//# sourceMappingURL=sc-cart-icon.cjs.entry.js.map