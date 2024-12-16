'use strict';

Object.defineProperty(exports, '__esModule', { value: true });

const index = require('./index-8acc3c89.js');
const mutations = require('./mutations-19357660.js');
require('./watchers-9d0e8382.js');
const getters = require('./getters-c1b89891.js');
const watchers = require('./watchers-2ad3abd1.js');
const MockProcessor = require('./MockProcessor-48b83649.js');
const addQueryArgs = require('./add-query-args-49dcb630.js');
require('./index-bcdafe6e.js');
require('./utils-ee1bb9d3.js');
require('./remove-query-args-b57e8cd3.js');
require('./index-fb76df07.js');
require('./google-59d23803.js');
require('./currency-71fce0f0.js');
require('./store-1fb3d249.js');
require('./price-653ec1cb.js');
require('./util-b877b2bd.js');

const scPaymentCss = ":host{display:flex !important;flex-direction:column;gap:var(--sc-input-label-margin);position:relative;font-family:var(--sc-font-sans)}.sc-payment-toggle-summary{line-height:1;display:flex;align-items:center;gap:0.5em;font-weight:var(--sc-font-weight-semibold)}.sc-payment-label{display:flex;justify-content:space-between}.sc-payment-instructions{color:var(--sc-color-gray-600);font-size:var(--sc-font-size-small);line-height:var(--sc-line-height-dense)}.sc-payment__stripe-card-element{display:flex !important;flex-direction:column;gap:var(--sc-input-label-margin);position:relative}";
const ScPaymentStyle0 = scPaymentCss;

const ScPayment = class {
    constructor(hostRef) {
        index.registerInstance(this, hostRef);
        this.stripePaymentElement = undefined;
        this.disabledProcessorTypes = undefined;
        this.secureNotice = undefined;
        this.label = undefined;
        this.hideTestModeBadge = undefined;
    }
    componentWillLoad() {
        getters.state.disabled.processors = this.disabledProcessorTypes;
    }
    renderStripe(processor) {
        const title = getters.hasOtherAvailableCreditCardProcessor('stripe') ? wp.i18n.__('Credit Card (Stripe)', 'surecart') : wp.i18n.__('Credit Card', 'surecart');
        return (index.h("sc-payment-method-choice", { key: processor === null || processor === void 0 ? void 0 : processor.id, "processor-id": "stripe", card: this.stripePaymentElement }, index.h("span", { slot: "summary", class: "sc-payment-toggle-summary" }, index.h("sc-icon", { name: "credit-card", style: { fontSize: '24px' }, "aria-hidden": "true" }), index.h("span", null, title)), index.h("div", { class: "sc-payment__stripe-card-element" }, index.h("slot", { name: "stripe" }))));
    }
    renderPayPal(processor) {
        return (index.h(index.Fragment, null, index.h("sc-payment-method-choice", { key: processor === null || processor === void 0 ? void 0 : processor.id, "processor-id": "paypal" }, index.h("span", { slot: "summary", class: "sc-payment-toggle-summary" }, index.h("sc-icon", { name: "paypal", style: { width: '80px', fontSize: '24px' }, "aria-hidden": "true" }), index.h("sc-visually-hidden", null, wp.i18n.__('PayPal', 'surecart'))), index.h("sc-card", null, index.h("sc-payment-selected", { label: wp.i18n.__('PayPal selected for check out.', 'surecart') }, index.h("sc-icon", { slot: "icon", name: "paypal", style: { width: '80px' }, "aria-hidden": "true" }), wp.i18n.__('Another step will appear after submitting your order to complete your purchase details.', 'surecart')))), !getters.hasOtherAvailableCreditCardProcessor('paypal') && (index.h("sc-payment-method-choice", { key: processor === null || processor === void 0 ? void 0 : processor.id, "processor-id": "paypal", "method-id": "card" }, index.h("span", { slot: "summary", class: "sc-payment-toggle-summary" }, index.h("sc-icon", { name: "credit-card", style: { fontSize: '24px' }, "aria-hidden": "true" }), index.h("span", null, wp.i18n.__('Credit Card', 'surecart'))), index.h("sc-card", null, index.h("sc-payment-selected", { label: wp.i18n.__('Credit Card selected for check out.', 'surecart') }, index.h("sc-icon", { name: "credit-card", slot: "icon", style: { fontSize: '24px' }, "aria-hidden": "true" }), wp.i18n.__('Another step will appear after submitting your order to complete your purchase details.', 'surecart')))))));
    }
    renderMock(processor) {
        return index.h(MockProcessor.MockProcessor, { processor: processor });
    }
    renderPaystack(processor) {
        var _a, _b;
        const title = getters.hasOtherAvailableCreditCardProcessor('paystack') ? wp.i18n.__('Credit Card (Paystack)', 'surecart') : wp.i18n.__('Credit Card', 'surecart');
        // if system currency is not in the supported currency list, then stop.
        if (!((_a = processor === null || processor === void 0 ? void 0 : processor.supported_currencies) !== null && _a !== void 0 ? _a : []).includes((_b = window === null || window === void 0 ? void 0 : window.scData) === null || _b === void 0 ? void 0 : _b.currency)) {
            return;
        }
        return (index.h("sc-payment-method-choice", { key: processor === null || processor === void 0 ? void 0 : processor.id, "processor-id": "paystack" }, index.h("span", { slot: "summary", class: "sc-payment-toggle-summary" }, index.h("sc-icon", { name: "credit-card", style: { fontSize: '24px' }, "aria-hidden": "true" }), index.h("span", null, title)), index.h("sc-card", null, index.h("sc-payment-selected", { label: wp.i18n.__('Credit Card selected for check out.', 'surecart') }, index.h("sc-icon", { slot: "icon", name: "credit-card", "aria-hidden": "true" }), wp.i18n.__('Another step will appear after submitting your order to complete your purchase details.', 'surecart'))), index.h("sc-checkout-paystack-payment-provider", null)));
    }
    render() {
        var _a, _b, _c, _d, _e, _f;
        // payment is not required for this order.
        if (((_a = mutations.state.checkout) === null || _a === void 0 ? void 0 : _a.payment_method_required) === false) {
            return null;
        }
        const Tag = getters.hasMultipleProcessorChoices() || (watchers.state === null || watchers.state === void 0 ? void 0 : watchers.state.id) === 'paypal' ? 'sc-toggles' : 'div';
        const mollie = getters.getAvailableProcessor('mollie');
        return (index.h(index.Host, null, index.h("sc-form-control", { label: this.label, exportparts: "label, help-text, form-control" }, index.h("div", { class: "sc-payment-label", slot: "label" }, index.h("div", null, this.label), mutations.state.mode === 'test' && !this.hideTestModeBadge && (index.h("sc-tag", { type: "warning", size: "small", exportparts: "base:test-badge__base, content:test-badge__content" }, wp.i18n.__('Test Mode', 'surecart')))), (mollie === null || mollie === void 0 ? void 0 : mollie.id) ? (index.h("sc-checkout-mollie-payment", { "processor-id": mollie === null || mollie === void 0 ? void 0 : mollie.id })) : (index.h(Tag, { collapsible: false, theme: "container" }, !((_b = getters.availableProcessors()) === null || _b === void 0 ? void 0 : _b.length) && !((_c = getters.availableManualPaymentMethods()) === null || _c === void 0 ? void 0 : _c.length) && (index.h("sc-alert", { type: "info", open: true }, ((_e = (_d = window === null || window === void 0 ? void 0 : window.scData) === null || _d === void 0 ? void 0 : _d.user_permissions) === null || _e === void 0 ? void 0 : _e.manage_sc_shop_settings) ? (index.h(index.Fragment, null, wp.i18n.__('You do not have any processors enabled for this mode and cart. ', 'surecart'), index.h("a", { href: addQueryArgs.addQueryArgs(`${(_f = window === null || window === void 0 ? void 0 : window.scData) === null || _f === void 0 ? void 0 : _f.admin_url}admin.php`, {
                page: 'sc-settings',
                tab: 'processors',
            }), style: { color: 'var(--sc-color-gray-700)' } }, wp.i18n.__('Please configure your processors', 'surecart')), ".")) : (wp.i18n.__('Please contact us for payment.', 'surecart')))), (getters.availableProcessors() || []).map(processor => {
            switch (processor === null || processor === void 0 ? void 0 : processor.processor_type) {
                case 'stripe':
                    return this.renderStripe(processor);
                case 'paypal':
                    return this.renderPayPal(processor);
                case 'paystack':
                    return this.renderPaystack(processor);
                case 'mock':
                    return this.renderMock(processor);
            }
        }), index.h(MockProcessor.ManualPaymentMethods, { methods: getters.availableManualPaymentMethods() }))))));
    }
    get el() { return index.getElement(this); }
};
ScPayment.style = ScPaymentStyle0;

exports.sc_payment = ScPayment;

//# sourceMappingURL=sc-payment.cjs.entry.js.map