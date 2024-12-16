'use strict';

Object.defineProperty(exports, '__esModule', { value: true });

const index = require('./index-8acc3c89.js');
const fetch = require('./fetch-f25a0cb0.js');
const addQueryArgs = require('./add-query-args-49dcb630.js');
require('./remove-query-args-b57e8cd3.js');

const scSubscriptionPaymentCss = ":host{display:block;position:relative}.subscription-payment{display:grid;gap:0.5em}";
const ScSubscriptionPaymentStyle0 = scSubscriptionPaymentCss;

const ScSubscriptionPayment = class {
    constructor(hostRef) {
        index.registerInstance(this, hostRef);
        this.subscriptionId = undefined;
        this.backUrl = undefined;
        this.successUrl = undefined;
        this.subscription = undefined;
        this.paymentMethods = [];
        this.customerIds = [];
        this.manualPaymentMethods = undefined;
        this.loading = undefined;
        this.busy = undefined;
        this.error = undefined;
    }
    componentWillLoad() {
        this.fetchItems();
    }
    async fetchItems() {
        try {
            this.loading = true;
            await Promise.all([this.fetchSubscription(), this.fetchPaymentMethods()]);
        }
        catch (e) {
            console.error(e);
            this.error = (e === null || e === void 0 ? void 0 : e.message) || wp.i18n.__('Something went wrong', 'surecart');
        }
        finally {
            this.loading = false;
        }
    }
    async fetchSubscription() {
        if (!this.subscriptionId)
            return;
        this.subscription = (await fetch.apiFetch({
            path: addQueryArgs.addQueryArgs(`/surecart/v1/subscriptions/${this.subscriptionId}`, {
                expand: ['price', 'price.product', 'current_period', 'product'],
            }),
        }));
    }
    async fetchPaymentMethods() {
        var _a, _b;
        this.paymentMethods = (await fetch.apiFetch({
            path: addQueryArgs.addQueryArgs(`/surecart/v1/payment_methods`, {
                expand: ['card', 'customer', 'billing_agreement', 'paypal_account', 'payment_instrument', 'bank_account'],
                customer_ids: this.customerIds,
                reusable: true,
                ...(((_a = this.subscription) === null || _a === void 0 ? void 0 : _a.live_mode) !== null ? { live_mode: this.subscription.live_mode } : {}),
            }),
        }));
        this.manualPaymentMethods = (await fetch.apiFetch({
            path: addQueryArgs.addQueryArgs(`surecart/v1/manual_payment_methods`, {
                customer_ids: this.customerIds,
                reusable: true,
                live_mode: (_b = this.subscription) === null || _b === void 0 ? void 0 : _b.live_mode,
            }),
        }));
    }
    async handleSubmit(e) {
        var _a;
        const { payment_method } = await e.target.getFormJson();
        const isManualPaymentMethod = (this.manualPaymentMethods || []).some(method => method.id === payment_method);
        try {
            this.error = '';
            this.busy = true;
            await fetch.apiFetch({
                path: `/surecart/v1/subscriptions/${(_a = this.subscription) === null || _a === void 0 ? void 0 : _a.id}`,
                method: 'PATCH',
                data: {
                    ...(!isManualPaymentMethod ? { payment_method, manual_payment: false } : { manual_payment_method: payment_method, manual_payment: true }),
                },
            });
            if (this.successUrl) {
                window.location.assign(this.successUrl);
            }
            else {
                this.busy = false;
            }
        }
        catch (e) {
            this.error = (e === null || e === void 0 ? void 0 : e.message) || wp.i18n.__('Something went wrong', 'surecart');
            this.busy = false;
        }
    }
    renderLoading() {
        return (index.h(index.Fragment, null, index.h("sc-choice", { name: "loading", disabled: true }, index.h("sc-skeleton", { style: { width: '60px', display: 'inline-block' } }), index.h("sc-skeleton", { style: { width: '80px', display: 'inline-block' }, slot: "price" }), index.h("sc-skeleton", { style: { width: '120px', display: 'inline-block' }, slot: "description" })), index.h("sc-button", { type: "primary", full: true, submit: true, loading: true, busy: true }), !!this.backUrl && index.h("sc-button", { href: this.backUrl, full: true, loading: true, busy: true })));
    }
    renderContent() {
        var _a, _b, _c, _d, _e, _f, _g, _h;
        if (this.loading) {
            return this.renderLoading();
        }
        const modeMethods = this.paymentMethods.filter(method => { var _a; return (method === null || method === void 0 ? void 0 : method.live_mode) === ((_a = this.subscription) === null || _a === void 0 ? void 0 : _a.live_mode); });
        const hasNoPaymentMethods = (!((_a = this.paymentMethods) === null || _a === void 0 ? void 0 : _a.length) && !((_b = this.manualPaymentMethods) === null || _b === void 0 ? void 0 : _b.length)) || (((_c = this.paymentMethods) === null || _c === void 0 ? void 0 : _c.length) && !(modeMethods === null || modeMethods === void 0 ? void 0 : modeMethods.length));
        const currentPaymentMethodId = ((_d = this.subscription) === null || _d === void 0 ? void 0 : _d.manual_payment)
            ? (_e = this.subscription) === null || _e === void 0 ? void 0 : _e.manual_payment_method
            : ((_g = (_f = this.subscription) === null || _f === void 0 ? void 0 : _f.payment_method) === null || _g === void 0 ? void 0 : _g.id) || ((_h = this.subscription) === null || _h === void 0 ? void 0 : _h.payment_method);
        if (hasNoPaymentMethods) {
            return (index.h(index.Fragment, null, index.h("sc-empty", { icon: "credit-card" }, wp.i18n.__('You have no saved payment methods.', 'surecart')), !!this.backUrl && (index.h("sc-button", { href: this.backUrl, full: true }, wp.i18n.__('Go Back', 'surecart')))));
        }
        return (index.h(index.Fragment, null, index.h("sc-choices", null, index.h("div", null, (this.paymentMethods || []).map(method => {
            var _a;
            if ((method === null || method === void 0 ? void 0 : method.live_mode) !== ((_a = this === null || this === void 0 ? void 0 : this.subscription) === null || _a === void 0 ? void 0 : _a.live_mode))
                return null;
            return (index.h("sc-choice", { checked: currentPaymentMethodId === (method === null || method === void 0 ? void 0 : method.id), name: "payment_method", value: method === null || method === void 0 ? void 0 : method.id }, index.h("sc-payment-method", { paymentMethod: method, full: true })));
        }), (this.manualPaymentMethods || []).map(method => {
            return (index.h("sc-choice", { checked: currentPaymentMethodId === (method === null || method === void 0 ? void 0 : method.id), name: "payment_method", value: method === null || method === void 0 ? void 0 : method.id }, index.h("sc-manual-payment-method", { paymentMethod: method, showDescription: true })));
        }))), index.h("sc-button", { type: "primary", full: true, submit: true, loading: this.loading || this.busy, disabled: this.loading || this.busy }, wp.i18n.__('Update', 'surecart')), !!this.backUrl && (index.h("sc-button", { href: this.backUrl, full: true, loading: this.loading || this.busy, disabled: this.loading || this.busy }, wp.i18n.__('Go Back', 'surecart')))));
    }
    render() {
        return (index.h("sc-dashboard-module", { key: 'b36b067fe53f870c482da572ebe8d1ceabc75610', heading: wp.i18n.__('Select a payment method', 'surecart'), class: "subscription-payment", error: this.error }, index.h("sc-form", { key: 'abf9f2a99540fe3e278924c49768622d2bd0f773', onScFormSubmit: e => this.handleSubmit(e) }, index.h("sc-card", { key: 'b772e2343296ec73a5ebc30e7301005bc5caf39a' }, this.renderContent())), this.busy && index.h("sc-block-ui", { key: '1d332cb4cd77df1aaf3109d4da64ccd7dddb5fc4' })));
    }
};
ScSubscriptionPayment.style = ScSubscriptionPaymentStyle0;

exports.sc_subscription_payment = ScSubscriptionPayment;

//# sourceMappingURL=sc-subscription-payment.cjs.entry.js.map