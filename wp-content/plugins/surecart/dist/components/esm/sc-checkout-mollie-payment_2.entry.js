import { r as registerInstance, h, F as Fragment } from './index-745b6bec.js';
import { s as state } from './watchers-38693c1f.js';
import './watchers-94c3ca47.js';
import { s as state$1, c as availableMethodTypes, f as hasMultipleMethodChoices, e as getAvailableProcessor, b as availableManualPaymentMethods } from './getters-ff7a502e.js';
import { e as on, s as state$2, u as updateFormState } from './mutations-d5e8faea.js';
import { a as checkoutIsLocked } from './getters-e4172581.js';
import { l as lockCheckout, b as unLockCheckout } from './mutations-01792dfb.js';
import { a as apiFetch } from './fetch-2032d11d.js';
import { a as MockProcessor, M as ManualPaymentMethods } from './MockProcessor-498b60c5.js';
import { c as createErrorNotice } from './mutations-ed6d0770.js';
import { a as addQueryArgs } from './add-query-args-0e2a8393.js';
import { s as se } from './inline-c012a0f9.js';
import { o as onChange } from './store-7020541e.js';
import { c as currentFormState } from './getters-929aa1df.js';
import './index-06061d4e.js';
import './util-50af2a83.js';
import './utils-e9ee502a.js';
import './remove-query-args-938c53ea.js';
import './index-c5a96d53.js';
import './google-a86aa761.js';
import './currency-a0c9bff4.js';
import './price-d5770168.js';
import './address-b892540d.js';
import './index-96490395.js';

const listenTo = (prop, propKey, callback) => on('set', (key, newValue, oldValue) => {
    // ignore non-keys
    if (key !== prop)
        return;
    // handle an array, if one has changed, run callback.
    if (Array.isArray(propKey)) {
        if (propKey.some(key => JSON.stringify(newValue === null || newValue === void 0 ? void 0 : newValue[key]) !== JSON.stringify(oldValue === null || oldValue === void 0 ? void 0 : oldValue[key]))) {
            return callback(newValue, oldValue);
        }
    }
    // handle string.
    if (typeof propKey === 'string') {
        if (JSON.stringify(newValue === null || newValue === void 0 ? void 0 : newValue[propKey]) === JSON.stringify(oldValue === null || oldValue === void 0 ? void 0 : oldValue[propKey]))
            return;
        return callback(newValue === null || newValue === void 0 ? void 0 : newValue[propKey], oldValue === null || oldValue === void 0 ? void 0 : oldValue[propKey]);
    }
});

const scCheckoutMolliePaymentCss = ":host{display:block}";
const ScCheckoutMolliePaymentStyle0 = scCheckoutMolliePaymentCss;

const ScCheckoutMolliePayment = class {
    constructor(hostRef) {
        registerInstance(this, hostRef);
        this.processorId = undefined;
        this.method = undefined;
        this.error = undefined;
        this.methods = undefined;
    }
    componentWillLoad() {
        state.id = 'mollie';
        this.fetchMethods();
        listenTo('checkout', ['total_amount', 'currency', 'reusabled_payment_method_required', 'shipping_address'], () => this.fetchMethods());
    }
    async fetchMethods() {
        var _a;
        const checkout = state$2.checkout;
        if (!(checkout === null || checkout === void 0 ? void 0 : checkout.currency) || !(checkout === null || checkout === void 0 ? void 0 : checkout.total_amount))
            return; // wait until we have a currency.
        try {
            lockCheckout('methods');
            const response = (await apiFetch({
                path: addQueryArgs(`surecart/v1/processors/${this.processorId}/payment_method_types`, {
                    amount: checkout === null || checkout === void 0 ? void 0 : checkout.total_amount,
                    country: ((_a = checkout === null || checkout === void 0 ? void 0 : checkout.shipping_address) === null || _a === void 0 ? void 0 : _a.country) || 'us',
                    currency: checkout === null || checkout === void 0 ? void 0 : checkout.currency,
                    ...((checkout === null || checkout === void 0 ? void 0 : checkout.reusable_payment_method_required) ? { reusable: checkout === null || checkout === void 0 ? void 0 : checkout.reusable_payment_method_required } : {}),
                    per_page: 100,
                }),
            }));
            state$1.methods = (response === null || response === void 0 ? void 0 : response.data) || [];
        }
        catch (e) {
            createErrorNotice(e);
            console.error(e);
        }
        finally {
            unLockCheckout('methods');
        }
    }
    renderLoading() {
        return (h("sc-card", null, h("sc-skeleton", { style: { width: '50%', marginBottom: '0.5em' } }), h("sc-skeleton", { style: { width: '30%', marginBottom: '0.5em' } }), h("sc-skeleton", { style: { width: '60%', marginBottom: '0.5em' } })));
    }
    render() {
        var _a, _b, _c;
        if (checkoutIsLocked('methods') && !((_a = availableMethodTypes()) === null || _a === void 0 ? void 0 : _a.length)) {
            return this.renderLoading();
        }
        if (!((_b = state$2.checkout) === null || _b === void 0 ? void 0 : _b.currency)) {
            return this.renderLoading();
        }
        if (!((_c = availableMethodTypes()) === null || _c === void 0 ? void 0 : _c.length)) {
            return (h("sc-alert", { type: "warning", open: true }, wp.i18n.__('No available payment methods', 'surecart'), ' '));
        }
        const Tag = hasMultipleMethodChoices() ? 'sc-toggles' : 'div';
        return (h(Fragment, null, h(Tag, { collapsible: false, theme: "container" }, (availableMethodTypes() || []).map(method => (h("sc-payment-method-choice", { "processor-id": "mollie", "method-id": method === null || method === void 0 ? void 0 : method.id, key: method === null || method === void 0 ? void 0 : method.id }, h("span", { slot: "summary", class: "sc-payment-toggle-summary" }, !!(method === null || method === void 0 ? void 0 : method.image) && h("img", { src: method === null || method === void 0 ? void 0 : method.image, "aria-hidden": "true" }), h("span", null, method === null || method === void 0 ? void 0 : method.description)), h("sc-card", null, h("sc-payment-selected", { label: wp.i18n.sprintf(wp.i18n.__('%s selected for check out.', 'surecart'), method === null || method === void 0 ? void 0 : method.description) }, !!(method === null || method === void 0 ? void 0 : method.image) && h("img", { slot: "icon", src: method === null || method === void 0 ? void 0 : method.image, style: { width: '32px' } }), wp.i18n.__('Another step will appear after submitting your order to complete your purchase details.', 'surecart')))))), h(MockProcessor, { processor: getAvailableProcessor('mock') }), h(ManualPaymentMethods, { methods: availableManualPaymentMethods() })), !!checkoutIsLocked('methods') && h("sc-block-ui", { class: "busy-block-ui", "z-index": 9, style: { '--sc-block-ui-opacity': '0.4' } })));
    }
};
ScCheckoutMolliePayment.style = ScCheckoutMolliePaymentStyle0;

const ScCheckoutPaystackPaymentProvider = class {
    constructor(hostRef) {
        registerInstance(this, hostRef);
    }
    componentWillLoad() {
        // we need to listen to the form state and pay when the form state enters the paying state.
        this.unlistenToFormState = onChange('formState', () => {
            // are we paying?
            if ('paying' === currentFormState()) {
                this.confirm();
            }
        });
    }
    disconnectedCallback() {
        this.unlistenToFormState();
    }
    async confirm() {
        var _a, _b, _c, _d;
        // this processor is not selected.
        if ((state === null || state === void 0 ? void 0 : state.id) !== 'paystack')
            return;
        // Must be a paystack session
        if (!((_b = (_a = state$2 === null || state$2 === void 0 ? void 0 : state$2.checkout) === null || _a === void 0 ? void 0 : _a.payment_intent) === null || _b === void 0 ? void 0 : _b.processor_data.paystack))
            return;
        // Prevent if already paid.
        if (((_c = state$2 === null || state$2 === void 0 ? void 0 : state$2.checkout) === null || _c === void 0 ? void 0 : _c.status) === 'paid')
            return;
        try {
            // must have a public key and access code.
            const { public_key, access_code } = (_d = state$2 === null || state$2 === void 0 ? void 0 : state$2.checkout) === null || _d === void 0 ? void 0 : _d.payment_intent.processor_data.paystack;
            if (!public_key || !access_code) {
                createErrorNotice({ message: wp.i18n.sprintf(wp.i18n.__('Payment gateway configuration incomplete. Please ensure Paystack is properly configured for transactions.', 'surecart')) });
                return;
            }
            const paystack = new se();
            await paystack.newTransaction({
                key: public_key,
                accessCode: access_code, // We'll use accessCode which will handle product, price on our server.
                onSuccess: async (transaction) => {
                    if ((transaction === null || transaction === void 0 ? void 0 : transaction.status) !== 'success') {
                        throw { message: wp.i18n.sprintf(wp.i18n.__('Paystack transaction could not be finished. Status: %s', 'surecart'), transaction === null || transaction === void 0 ? void 0 : transaction.status) };
                    }
                    return updateFormState('PAID');
                },
                onClose: () => updateFormState('REJECT'),
            });
        }
        catch (err) {
            createErrorNotice(err);
            console.error(err);
            updateFormState('REJECT');
        }
    }
};

export { ScCheckoutMolliePayment as sc_checkout_mollie_payment, ScCheckoutPaystackPaymentProvider as sc_checkout_paystack_payment_provider };

//# sourceMappingURL=sc-checkout-mollie-payment_2.entry.js.map