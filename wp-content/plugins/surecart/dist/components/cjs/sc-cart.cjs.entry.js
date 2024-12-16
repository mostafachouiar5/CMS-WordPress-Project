'use strict';

Object.defineProperty(exports, '__esModule', { value: true });

const index = require('./index-8acc3c89.js');
const fetch = require('./fetch-f25a0cb0.js');
const index$1 = require('./index-771f480e.js');
const mutations = require('./mutations-19357660.js');
const mutations$1 = require('./mutations-11c8f9a8.js');
const getters = require('./getters-690e042a.js');
const addQueryArgs = require('./add-query-args-49dcb630.js');
require('./remove-query-args-b57e8cd3.js');
require('./index-bcdafe6e.js');
require('./utils-ee1bb9d3.js');
require('./index-fb76df07.js');
require('./google-59d23803.js');
require('./currency-71fce0f0.js');
require('./store-1fb3d249.js');
require('./price-653ec1cb.js');

const scCartCss = ":host{--sc-drawer-header-spacing:var(--sc-spacing-large);--sc-drawer-body-spacing:var(--sc-spacing-large);--sc-drawer-footer-spacing:var(--sc-spacing-large)}.cart{font-size:16px}.cart__header{display:flex;align-items:center;justify-content:space-between;width:100%;font-size:1em}.cart__close{opacity:0.75;transition:opacity 0.25s ease;cursor:pointer}.cart__close:hover{opacity:1}::slotted(*){padding:var(--sc-drawer-header-spacing);background:var(--sc-panel-background-color);position:relative}::slotted(sc-line-items){flex:1 1 auto;overflow:auto;-webkit-overflow-scrolling:touch;min-height:200px}::slotted(:last-child){border-bottom:0 !important}sc-drawer::part(body){display:flex;flex-direction:column;box-sizing:border-box;padding:0;overflow:hidden}";
const ScCartStyle0 = scCartCss;

const ScCart = class {
    constructor(hostRef) {
        index.registerInstance(this, hostRef);
        this.open = null;
        this.formId = undefined;
        this.header = undefined;
        this.checkoutLink = undefined;
        this.cartTemplate = undefined;
        this.mode = 'live';
        this.checkoutUrl = undefined;
        this.alwaysShow = undefined;
        this.floatingIconEnabled = true;
        this.uiState = 'idle';
    }
    handleOpenChange() {
        var _a, _b, _c;
        mutations.store.set('cart', { ...mutations.store.state.cart, ...{ open: this.open } });
        if (this.open === true) {
            this.fetchOrder();
        }
        else {
            (_c = (_b = (_a = document === null || document === void 0 ? void 0 : document.querySelector('sc-cart-icon')) === null || _a === void 0 ? void 0 : _a.shadowRoot) === null || _b === void 0 ? void 0 : _b.querySelector('.cart')) === null || _c === void 0 ? void 0 : _c.focus();
        }
    }
    order() {
        return mutations.getCheckout(this.formId, this.mode);
    }
    setCheckout(data) {
        mutations.setCheckout(data, this.formId);
    }
    /**
     * Search for the sc-checkout component on a page to make sure
     * we don't show the cart on a checkout page.
     */
    pageHasForm() {
        return !!document.querySelector('sc-checkout');
    }
    /** Count the number of items in the cart. */
    getItemsCount() {
        var _a, _b;
        const items = (_b = (_a = mutations.state.checkout) === null || _a === void 0 ? void 0 : _a.line_items) === null || _b === void 0 ? void 0 : _b.data;
        let count = 0;
        (items || []).forEach(item => {
            count = count + (item === null || item === void 0 ? void 0 : item.quantity);
        });
        return count;
    }
    handleSetState(e) {
        this.uiState = e.detail;
    }
    handleCloseCart() {
        this.open = false;
    }
    /** Fetch the order */
    async fetchOrder() {
        var _a, _b;
        if (!((_a = mutations.state.checkout) === null || _a === void 0 ? void 0 : _a.id)) {
            return;
        }
        try {
            mutations.updateFormState('FETCH');
            mutations.state.checkout = (await fetch.apiFetch({
                method: 'GET', // create or update
                path: addQueryArgs.addQueryArgs(`${index$1.baseUrl}${(_b = mutations.state.checkout) === null || _b === void 0 ? void 0 : _b.id}`, {
                    expand: index$1.expand,
                }),
            }));
            mutations.updateFormState('RESOLVE');
        }
        catch (e) {
            console.error(e);
            mutations.updateFormState('REJECT');
            mutations$1.createErrorNotice(e);
            if ((e === null || e === void 0 ? void 0 : e.code) === 'checkout.not_found') {
                mutations.clearCheckout(this.formId, this.mode);
            }
        }
    }
    componentWillLoad() {
        this.open = !!mutations.store.state.cart.open;
        mutations.store.onChange('cart', cart => {
            this.open = cart.open;
        });
    }
    state() {
        var _a, _b, _c, _d, _e, _f, _g, _h, _j, _k, _l;
        return {
            uiState: this.uiState,
            checkoutLink: this.checkoutLink,
            loading: this.uiState === 'loading',
            busy: this.uiState === 'busy',
            navigating: this.uiState === 'navigating',
            empty: !((_c = (_b = (_a = mutations.state.checkout) === null || _a === void 0 ? void 0 : _a.line_items) === null || _b === void 0 ? void 0 : _b.pagination) === null || _c === void 0 ? void 0 : _c.count),
            order: mutations.state.checkout,
            lineItems: ((_e = (_d = mutations.state.checkout) === null || _d === void 0 ? void 0 : _d.line_items) === null || _e === void 0 ? void 0 : _e.data) || [],
            tax_status: (_f = mutations.state.checkout) === null || _f === void 0 ? void 0 : _f.tax_status,
            customerShippingAddress: typeof ((_g = mutations.state.checkout) === null || _g === void 0 ? void 0 : _g.customer) !== 'string' ? (_j = (_h = mutations.state.checkout) === null || _h === void 0 ? void 0 : _h.customer) === null || _j === void 0 ? void 0 : _j.shipping_address : {},
            shippingAddress: (_k = mutations.state.checkout) === null || _k === void 0 ? void 0 : _k.shipping_address,
            taxStatus: (_l = mutations.state.checkout) === null || _l === void 0 ? void 0 : _l.tax_status,
            formId: this.formId,
        };
    }
    render() {
        return (index.h("sc-cart-session-provider", { key: '560c163d6734b8e3523aa3ef694402087bb8d925' }, index.h("sc-drawer", { key: 'afef03ec7696549111ea08d98f082b16a12bd089', open: this.open, onScAfterShow: () => (this.open = true), onScAfterHide: () => {
                this.open = false;
            } }, this.open === true && (index.h(index.Fragment, { key: '587340601c82b370c27c1eb24ee656a376703e27' }, index.h("div", { key: 'c97b85fc5346f04a8c6c1f9620ed5fb5da93ad52', class: "cart__header-suffix", slot: "header" }, index.h("slot", { key: '90c42dc0deca0417a7c2c0e34dcb98ea61bf9b09', name: "cart-header" }), index.h("sc-error", { key: '2dfa19f7e78f4203b0e0bd84c33dc23406e5f052', style: { '--sc-alert-border-radius': '0' }, slot: "header" })), index.h("slot", { key: '7eeb0334a95f5d87bba56813e38cb76017ea09c1' }))), getters.formBusy() && index.h("sc-block-ui", { key: '006485d36e0db4fe8d635b56250df23aae6a9056', "z-index": 9 }))));
    }
    get el() { return index.getElement(this); }
    static get watchers() { return {
        "open": ["handleOpenChange"]
    }; }
};
ScCart.style = ScCartStyle0;

exports.sc_cart = ScCart;

//# sourceMappingURL=sc-cart.cjs.entry.js.map