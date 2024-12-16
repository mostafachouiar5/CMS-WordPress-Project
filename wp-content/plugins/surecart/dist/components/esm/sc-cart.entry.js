import { r as registerInstance, h, F as Fragment, a as getElement } from './index-745b6bec.js';
import { a as apiFetch } from './fetch-2032d11d.js';
import { e as expand, b as baseUrl } from './index-96490395.js';
import { a as store, g as getCheckout, b as setCheckout, s as state, u as updateFormState, c as clearCheckout } from './mutations-d5e8faea.js';
import { c as createErrorNotice } from './mutations-ed6d0770.js';
import { f as formBusy } from './getters-929aa1df.js';
import { a as addQueryArgs } from './add-query-args-0e2a8393.js';
import './remove-query-args-938c53ea.js';
import './index-06061d4e.js';
import './utils-e9ee502a.js';
import './index-c5a96d53.js';
import './google-a86aa761.js';
import './currency-a0c9bff4.js';
import './store-7020541e.js';
import './price-d5770168.js';

const scCartCss = ":host{--sc-drawer-header-spacing:var(--sc-spacing-large);--sc-drawer-body-spacing:var(--sc-spacing-large);--sc-drawer-footer-spacing:var(--sc-spacing-large)}.cart{font-size:16px}.cart__header{display:flex;align-items:center;justify-content:space-between;width:100%;font-size:1em}.cart__close{opacity:0.75;transition:opacity 0.25s ease;cursor:pointer}.cart__close:hover{opacity:1}::slotted(*){padding:var(--sc-drawer-header-spacing);background:var(--sc-panel-background-color);position:relative}::slotted(sc-line-items){flex:1 1 auto;overflow:auto;-webkit-overflow-scrolling:touch;min-height:200px}::slotted(:last-child){border-bottom:0 !important}sc-drawer::part(body){display:flex;flex-direction:column;box-sizing:border-box;padding:0;overflow:hidden}";
const ScCartStyle0 = scCartCss;

const ScCart = class {
    constructor(hostRef) {
        registerInstance(this, hostRef);
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
        store.set('cart', { ...store.state.cart, ...{ open: this.open } });
        if (this.open === true) {
            this.fetchOrder();
        }
        else {
            (_c = (_b = (_a = document === null || document === void 0 ? void 0 : document.querySelector('sc-cart-icon')) === null || _a === void 0 ? void 0 : _a.shadowRoot) === null || _b === void 0 ? void 0 : _b.querySelector('.cart')) === null || _c === void 0 ? void 0 : _c.focus();
        }
    }
    order() {
        return getCheckout(this.formId, this.mode);
    }
    setCheckout(data) {
        setCheckout(data, this.formId);
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
        const items = (_b = (_a = state.checkout) === null || _a === void 0 ? void 0 : _a.line_items) === null || _b === void 0 ? void 0 : _b.data;
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
        if (!((_a = state.checkout) === null || _a === void 0 ? void 0 : _a.id)) {
            return;
        }
        try {
            updateFormState('FETCH');
            state.checkout = (await apiFetch({
                method: 'GET', // create or update
                path: addQueryArgs(`${baseUrl}${(_b = state.checkout) === null || _b === void 0 ? void 0 : _b.id}`, {
                    expand,
                }),
            }));
            updateFormState('RESOLVE');
        }
        catch (e) {
            console.error(e);
            updateFormState('REJECT');
            createErrorNotice(e);
            if ((e === null || e === void 0 ? void 0 : e.code) === 'checkout.not_found') {
                clearCheckout(this.formId, this.mode);
            }
        }
    }
    componentWillLoad() {
        this.open = !!store.state.cart.open;
        store.onChange('cart', cart => {
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
            empty: !((_c = (_b = (_a = state.checkout) === null || _a === void 0 ? void 0 : _a.line_items) === null || _b === void 0 ? void 0 : _b.pagination) === null || _c === void 0 ? void 0 : _c.count),
            order: state.checkout,
            lineItems: ((_e = (_d = state.checkout) === null || _d === void 0 ? void 0 : _d.line_items) === null || _e === void 0 ? void 0 : _e.data) || [],
            tax_status: (_f = state.checkout) === null || _f === void 0 ? void 0 : _f.tax_status,
            customerShippingAddress: typeof ((_g = state.checkout) === null || _g === void 0 ? void 0 : _g.customer) !== 'string' ? (_j = (_h = state.checkout) === null || _h === void 0 ? void 0 : _h.customer) === null || _j === void 0 ? void 0 : _j.shipping_address : {},
            shippingAddress: (_k = state.checkout) === null || _k === void 0 ? void 0 : _k.shipping_address,
            taxStatus: (_l = state.checkout) === null || _l === void 0 ? void 0 : _l.tax_status,
            formId: this.formId,
        };
    }
    render() {
        return (h("sc-cart-session-provider", { key: '560c163d6734b8e3523aa3ef694402087bb8d925' }, h("sc-drawer", { key: 'afef03ec7696549111ea08d98f082b16a12bd089', open: this.open, onScAfterShow: () => (this.open = true), onScAfterHide: () => {
                this.open = false;
            } }, this.open === true && (h(Fragment, { key: '587340601c82b370c27c1eb24ee656a376703e27' }, h("div", { key: 'c97b85fc5346f04a8c6c1f9620ed5fb5da93ad52', class: "cart__header-suffix", slot: "header" }, h("slot", { key: '90c42dc0deca0417a7c2c0e34dcb98ea61bf9b09', name: "cart-header" }), h("sc-error", { key: '2dfa19f7e78f4203b0e0bd84c33dc23406e5f052', style: { '--sc-alert-border-radius': '0' }, slot: "header" })), h("slot", { key: '7eeb0334a95f5d87bba56813e38cb76017ea09c1' }))), formBusy() && h("sc-block-ui", { key: '006485d36e0db4fe8d635b56250df23aae6a9056', "z-index": 9 }))));
    }
    get el() { return getElement(this); }
    static get watchers() { return {
        "open": ["handleOpenChange"]
    }; }
};
ScCart.style = ScCartStyle0;

export { ScCart as sc_cart };

//# sourceMappingURL=sc-cart.entry.js.map