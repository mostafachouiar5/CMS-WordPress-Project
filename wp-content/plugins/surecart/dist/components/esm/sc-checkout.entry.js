import { r as registerInstance, c as createEvent, h, a as getElement } from './index-745b6bec.js';
import { s as state } from './mutations-d5e8faea.js';
import { s as state$1 } from './store-7020541e.js';
import { s as state$3 } from './store-a8bae355.js';
import './watchers-94c3ca47.js';
import { s as state$2 } from './getters-ff7a502e.js';
import { U as Universe } from './universe-5a73abb7.js';
import './index-06061d4e.js';
import './utils-e9ee502a.js';
import './remove-query-args-938c53ea.js';
import './add-query-args-0e2a8393.js';
import './index-c5a96d53.js';
import './google-a86aa761.js';
import './currency-a0c9bff4.js';
import './price-d5770168.js';
import './watchers-38693c1f.js';
import './util-50af2a83.js';

const scCheckoutCss = "sc-checkout{--sc-form-focus-within-z-index:5;display:block;font-family:var(--sc-font-sans);font-size:var(--sc-checkout-font-size, 16px);position:relative}sc-checkout h3{font-size:var(--sc-input-label-font-size-medium)}sc-alert{margin-bottom:var(--sc-form-row-spacing)}.sc-checkout-container.sc-align-center{max-width:500px;margin-left:auto;margin-right:auto}.sc-checkout-container.sc-align-wide{max-width:800px;margin-left:auto;margin-right:auto}::slotted(*){font-family:var(--sc-font-sans)}";
const ScCheckoutStyle0 = scCheckoutCss;

const ScCheckout = class {
    constructor(hostRef) {
        registerInstance(this, hostRef);
        this.scOrderUpdated = createEvent(this, "scOrderUpdated", 7);
        this.scOrderFinalized = createEvent(this, "scOrderFinalized", 7);
        this.scOrderError = createEvent(this, "scOrderError", 7);
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
        state.checkout = e.detail;
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
        Universe.create(this, this.state());
    }
    state() {
        var _a, _b, _c, _d, _e, _f, _g, _h, _j, _k, _l, _m, _o, _p, _q, _r, _s, _t, _u, _v, _w, _x;
        return {
            processor: this.processor,
            method: this.method,
            selectedProcessorId: this.processor,
            manualPaymentMethods: this.manualPaymentMethods,
            processor_data: (_a = state.checkout) === null || _a === void 0 ? void 0 : _a.processor_data,
            state: this.checkoutState,
            formState: state$1.formState.value,
            paymentIntents: this.paymentIntents,
            successUrl: this.successUrl,
            bumps: (_c = (_b = state.checkout) === null || _b === void 0 ? void 0 : _b.recommended_bumps) === null || _c === void 0 ? void 0 : _c.data,
            order: state.checkout,
            abandonedCheckoutEnabled: (_d = state.checkout) === null || _d === void 0 ? void 0 : _d.abandoned_checkout_enabled,
            checkout: state.checkout,
            shippingEnabled: (_e = state.checkout) === null || _e === void 0 ? void 0 : _e.shipping_enabled,
            lineItems: ((_g = (_f = state.checkout) === null || _f === void 0 ? void 0 : _f.line_items) === null || _g === void 0 ? void 0 : _g.data) || [],
            editLineItems: this.editLineItems,
            removeLineItems: this.removeLineItems,
            // checkout states
            loading: state$1.formState.value === 'loading',
            busy: ['updating', 'finalizing', 'paying', 'confirming'].includes(state$1.formState.value),
            paying: ['finalizing', 'paying', 'confirming'].includes(state$1.formState.value),
            empty: !['loading', 'updating'].includes(state$1.formState.value) && !((_k = (_j = (_h = state.checkout) === null || _h === void 0 ? void 0 : _h.line_items) === null || _j === void 0 ? void 0 : _j.pagination) === null || _k === void 0 ? void 0 : _k.count),
            // checkout states
            // stripe.
            stripePaymentElement: state$2.config.stripe.paymentElement,
            stripePaymentIntent: (((_m = (_l = state.checkout) === null || _l === void 0 ? void 0 : _l.staged_payment_intents) === null || _m === void 0 ? void 0 : _m.data) || []).find(intent => intent.processor_type === 'stripe'),
            error: this.error,
            customer: this.customer,
            tax_status: (_o = state.checkout) === null || _o === void 0 ? void 0 : _o.tax_status,
            taxEnabled: (_p = state.checkout) === null || _p === void 0 ? void 0 : _p.tax_enabled,
            customerShippingAddress: typeof ((_q = state.checkout) === null || _q === void 0 ? void 0 : _q.customer) !== 'string' ? (_s = (_r = state.checkout) === null || _r === void 0 ? void 0 : _r.customer) === null || _s === void 0 ? void 0 : _s.shipping_address : {},
            shippingAddress: (_t = state.checkout) === null || _t === void 0 ? void 0 : _t.shipping_address,
            taxStatus: (_u = state.checkout) === null || _u === void 0 ? void 0 : _u.tax_status,
            taxIdentifier: (_v = state.checkout) === null || _v === void 0 ? void 0 : _v.tax_identifier,
            totalAmount: (_w = state.checkout) === null || _w === void 0 ? void 0 : _w.total_amount,
            taxProtocol: this.taxProtocol,
            lockedChoices: this.prices,
            products: this.productsEntities,
            prices: this.pricesEntities,
            country: 'US',
            loggedIn: state$3.loggedIn,
            emailExists: (_x = state.checkout) === null || _x === void 0 ? void 0 : _x.email_exists,
            formId: state.formId,
            mode: state.mode,
            currencyCode: state.currencyCode,
        };
    }
    render() {
        if (this.isDuplicate) {
            return h("sc-alert", { open: true }, wp.i18n.__('Due to processor restrictions, only one checkout form is allowed on the page.', 'surecart'));
        }
        return (h("div", { class: {
                'sc-checkout-container': true,
                'sc-align-center': this.alignment === 'center',
                'sc-align-wide': this.alignment === 'wide',
                'sc-align-full': this.alignment === 'full',
            } }, h("sc-checkout-unsaved-changes-warning", { state: this.checkoutState }), state.validateStock && h("sc-checkout-stock-alert", null), h(Universe.Provider, { state: this.state() }, h("sc-login-provider", { loggedIn: state$3.loggedIn, onScSetCustomer: e => (this.customer = e.detail), onScSetLoggedIn: e => (state$3.loggedIn = e.detail), order: state.checkout }, h("sc-form-state-provider", { onScSetCheckoutFormState: e => (this.checkoutState = e.detail) }, h("sc-form-error-provider", null, h("sc-form-components-validator", { disabled: this.disableComponentsValidation, taxProtocol: state.taxProtocol }, h("sc-order-confirm-provider", { "checkout-status": state$1.formState.value, "success-url": this.successUrl }, h("sc-session-provider", { ref: el => (this.sessionProvider = el), prices: this.prices, persist: this.persistSession }, h("slot", null))))))), this.state().busy && h("sc-block-ui", { class: "busy-block-ui", style: { 'z-index': '30' } }), ['finalizing', 'paying', 'confirming', 'confirmed', 'redirecting'].includes(state$1.formState.value) && (h("sc-block-ui", { spinner: true, style: { '--sc-block-ui-opacity': '0.75', 'z-index': '30' } }, state$1.text.loading[state$1.formState.value] || wp.i18n.__('Processing payment...', 'surecart'))), ['locked'].includes(state$1.formState.value) && (h("sc-block-ui", { style: { '--sc-block-ui-opacity': '1', 'z-index': '30', '--sc-block-ui-position': 'fixed', '--sc-block-ui-cursor': 'normal' } }, h("div", { style: { 'text-align': 'center', 'padding': '2rem', 'max-width': '600px' } }, wp.i18n.__('This invoice is not currently available for payment. If you have any questions, please contact us.', 'surecart')))), h("sc-checkout-test-complete", { "checkout-status": state$1.formState.value, "success-url": this.successUrl }))));
    }
    get el() { return getElement(this); }
};
ScCheckout.style = ScCheckoutStyle0;

export { ScCheckout as sc_checkout };

//# sourceMappingURL=sc-checkout.entry.js.map