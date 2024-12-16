'use strict';

Object.defineProperty(exports, '__esModule', { value: true });

const index = require('./index-8acc3c89.js');
const mutations = require('./mutations-19357660.js');
const store = require('./store-1fb3d249.js');
const store$1 = require('./store-34d62f12.js');
require('./watchers-9d0e8382.js');
const getters = require('./getters-c1b89891.js');
const universe = require('./universe-0cf1168a.js');
require('./index-bcdafe6e.js');
require('./utils-ee1bb9d3.js');
require('./remove-query-args-b57e8cd3.js');
require('./add-query-args-49dcb630.js');
require('./index-fb76df07.js');
require('./google-59d23803.js');
require('./currency-71fce0f0.js');
require('./price-653ec1cb.js');
require('./watchers-2ad3abd1.js');
require('./util-b877b2bd.js');

const scCheckoutCss = "sc-checkout{--sc-form-focus-within-z-index:5;display:block;font-family:var(--sc-font-sans);font-size:var(--sc-checkout-font-size, 16px);position:relative}sc-checkout h3{font-size:var(--sc-input-label-font-size-medium)}sc-alert{margin-bottom:var(--sc-form-row-spacing)}.sc-checkout-container.sc-align-center{max-width:500px;margin-left:auto;margin-right:auto}.sc-checkout-container.sc-align-wide{max-width:800px;margin-left:auto;margin-right:auto}::slotted(*){font-family:var(--sc-font-sans)}";
const ScCheckoutStyle0 = scCheckoutCss;

const ScCheckout = class {
    constructor(hostRef) {
        index.registerInstance(this, hostRef);
        this.scOrderUpdated = index.createEvent(this, "scOrderUpdated", 7);
        this.scOrderFinalized = index.createEvent(this, "scOrderFinalized", 7);
        this.scOrderError = index.createEvent(this, "scOrderError", 7);
        this.prices = [];
        this.product = undefined;
        this.mode = 'live';
        this.formId = undefined;
        this.modified = undefined;
        this.currencyCode = 'usd';
        this.persistSession = true;
        this.successUrl = '';
        this.customer = undefined;
        this.alignment = undefined;
        this.taxProtocol = undefined;
        this.disableComponentsValidation = undefined;
        this.processors = undefined;
        this.manualPaymentMethods = undefined;
        this.editLineItems = true;
        this.removeLineItems = true;
        this.abandonedCheckoutEnabled = undefined;
        this.stripePaymentElement = false;
        this.pricesEntities = {};
        this.productsEntities = {};
        this.checkoutState = 'idle';
        this.error = undefined;
        this.processor = 'stripe';
        this.method = undefined;
        this.isManualProcessor = undefined;
        this.paymentIntents = {};
        this.isDuplicate = undefined;
    }
    handleOrderStateUpdate(e) {
        mutations.state.checkout = e.detail;
    }
    handleMethodChange(e) {
        this.method = e.detail;
    }
    handleAddEntities(e) {
        const { products, prices } = e.detail;
        // add products.
        if (Object.keys((products === null || products === void 0 ? void 0 : products.length) || {})) {
            this.productsEntities = {
                ...this.productsEntities,
                ...products,
            };
        }
        // add prices.
        if (Object.keys((prices === null || prices === void 0 ? void 0 : prices.length) || {})) {
            this.pricesEntities = {
                ...this.pricesEntities,
                ...prices,
            };
        }
    }
    /**
     * Submit the form
     */
    async submit({ skip_validation } = { skip_validation: false }) {
        if (!skip_validation) {
            await this.validate();
        }
        return await this.sessionProvider.finalize();
    }
    /**
     * Validate the form.
     */
    async validate() {
        const form = this.el.querySelector('sc-form');
        return await form.validate();
    }
    componentWillLoad() {
        const checkout = document.querySelector('sc-checkout');
        this.isDuplicate = !!checkout && checkout !== this.el;
        if (this.isDuplicate)
            return;
        universe.Universe.create(this, this.state());
    }
    state() {
        var _a, _b, _c, _d, _e, _f, _g, _h, _j, _k, _l, _m, _o, _p, _q, _r, _s, _t, _u, _v, _w, _x;
        return {
            processor: this.processor,
            method: this.method,
            selectedProcessorId: this.processor,
            manualPaymentMethods: this.manualPaymentMethods,
            processor_data: (_a = mutations.state.checkout) === null || _a === void 0 ? void 0 : _a.processor_data,
            state: this.checkoutState,
            formState: store.state.formState.value,
            paymentIntents: this.paymentIntents,
            successUrl: this.successUrl,
            bumps: (_c = (_b = mutations.state.checkout) === null || _b === void 0 ? void 0 : _b.recommended_bumps) === null || _c === void 0 ? void 0 : _c.data,
            order: mutations.state.checkout,
            abandonedCheckoutEnabled: (_d = mutations.state.checkout) === null || _d === void 0 ? void 0 : _d.abandoned_checkout_enabled,
            checkout: mutations.state.checkout,
            shippingEnabled: (_e = mutations.state.checkout) === null || _e === void 0 ? void 0 : _e.shipping_enabled,
            lineItems: ((_g = (_f = mutations.state.checkout) === null || _f === void 0 ? void 0 : _f.line_items) === null || _g === void 0 ? void 0 : _g.data) || [],
            editLineItems: this.editLineItems,
            removeLineItems: this.removeLineItems,
            // checkout states
            loading: store.state.formState.value === 'loading',
            busy: ['updating', 'finalizing', 'paying', 'confirming'].includes(store.state.formState.value),
            paying: ['finalizing', 'paying', 'confirming'].includes(store.state.formState.value),
            empty: !['loading', 'updating'].includes(store.state.formState.value) && !((_k = (_j = (_h = mutations.state.checkout) === null || _h === void 0 ? void 0 : _h.line_items) === null || _j === void 0 ? void 0 : _j.pagination) === null || _k === void 0 ? void 0 : _k.count),
            // checkout states
            // stripe.
            stripePaymentElement: getters.state.config.stripe.paymentElement,
            stripePaymentIntent: (((_m = (_l = mutations.state.checkout) === null || _l === void 0 ? void 0 : _l.staged_payment_intents) === null || _m === void 0 ? void 0 : _m.data) || []).find(intent => intent.processor_type === 'stripe'),
            error: this.error,
            customer: this.customer,
            tax_status: (_o = mutations.state.checkout) === null || _o === void 0 ? void 0 : _o.tax_status,
            taxEnabled: (_p = mutations.state.checkout) === null || _p === void 0 ? void 0 : _p.tax_enabled,
            customerShippingAddress: typeof ((_q = mutations.state.checkout) === null || _q === void 0 ? void 0 : _q.customer) !== 'string' ? (_s = (_r = mutations.state.checkout) === null || _r === void 0 ? void 0 : _r.customer) === null || _s === void 0 ? void 0 : _s.shipping_address : {},
            shippingAddress: (_t = mutations.state.checkout) === null || _t === void 0 ? void 0 : _t.shipping_address,
            taxStatus: (_u = mutations.state.checkout) === null || _u === void 0 ? void 0 : _u.tax_status,
            taxIdentifier: (_v = mutations.state.checkout) === null || _v === void 0 ? void 0 : _v.tax_identifier,
            totalAmount: (_w = mutations.state.checkout) === null || _w === void 0 ? void 0 : _w.total_amount,
            taxProtocol: this.taxProtocol,
            lockedChoices: this.prices,
            products: this.productsEntities,
            prices: this.pricesEntities,
            country: 'US',
            loggedIn: store$1.state.loggedIn,
            emailExists: (_x = mutations.state.checkout) === null || _x === void 0 ? void 0 : _x.email_exists,
            formId: mutations.state.formId,
            mode: mutations.state.mode,
            currencyCode: mutations.state.currencyCode,
        };
    }
    render() {
        if (this.isDuplicate) {
            return index.h("sc-alert", { open: true }, wp.i18n.__('Due to processor restrictions, only one checkout form is allowed on the page.', 'surecart'));
        }
        return (index.h("div", { class: {
                'sc-checkout-container': true,
                'sc-align-center': this.alignment === 'center',
                'sc-align-wide': this.alignment === 'wide',
                'sc-align-full': this.alignment === 'full',
            } }, index.h("sc-checkout-unsaved-changes-warning", { state: this.checkoutState }), mutations.state.validateStock && index.h("sc-checkout-stock-alert", null), index.h(universe.Universe.Provider, { state: this.state() }, index.h("sc-login-provider", { loggedIn: store$1.state.loggedIn, onScSetCustomer: e => (this.customer = e.detail), onScSetLoggedIn: e => (store$1.state.loggedIn = e.detail), order: mutations.state.checkout }, index.h("sc-form-state-provider", { onScSetCheckoutFormState: e => (this.checkoutState = e.detail) }, index.h("sc-form-error-provider", null, index.h("sc-form-components-validator", { disabled: this.disableComponentsValidation, taxProtocol: mutations.state.taxProtocol }, index.h("sc-order-confirm-provider", { "checkout-status": store.state.formState.value, "success-url": this.successUrl }, index.h("sc-session-provider", { ref: el => (this.sessionProvider = el), prices: this.prices, persist: this.persistSession }, index.h("slot", null))))))), this.state().busy && index.h("sc-block-ui", { class: "busy-block-ui", style: { 'z-index': '30' } }), ['finalizing', 'paying', 'confirming', 'confirmed', 'redirecting'].includes(store.state.formState.value) && (index.h("sc-block-ui", { spinner: true, style: { '--sc-block-ui-opacity': '0.75', 'z-index': '30' } }, store.state.text.loading[store.state.formState.value] || wp.i18n.__('Processing payment...', 'surecart'))), ['locked'].includes(store.state.formState.value) && (index.h("sc-block-ui", { style: { '--sc-block-ui-opacity': '1', 'z-index': '30', '--sc-block-ui-position': 'fixed', '--sc-block-ui-cursor': 'normal' } }, index.h("div", { style: { 'text-align': 'center', 'padding': '2rem', 'max-width': '600px' } }, wp.i18n.__('This invoice is not currently available for payment. If you have any questions, please contact us.', 'surecart')))), index.h("sc-checkout-test-complete", { "checkout-status": store.state.formState.value, "success-url": this.successUrl }))));
    }
    get el() { return index.getElement(this); }
};
ScCheckout.style = ScCheckoutStyle0;

exports.sc_checkout = ScCheckout;

//# sourceMappingURL=sc-checkout.cjs.entry.js.map