'use strict';

Object.defineProperty(exports, '__esModule', { value: true });

const index = require('./index-8acc3c89.js');
const fetch = require('./fetch-f25a0cb0.js');
const lazy = require('./lazy-2b509fa7.js');
const addQueryArgs = require('./add-query-args-49dcb630.js');
require('./remove-query-args-b57e8cd3.js');

const scSubscriptionPaymentMethodCss = ":host{display:block}";
const ScSubscriptionPaymentMethodStyle0 = scSubscriptionPaymentMethodCss;

const ScSubscriptionPaymentMethod = class {
    constructor(hostRef) {
        index.registerInstance(this, hostRef);
        this.heading = undefined;
        this.subscription = undefined;
        this.paymentMethods = undefined;
        this.manualPaymentMethods = undefined;
        this.error = undefined;
        this.loading = undefined;
        this.busy = undefined;
        this.method = undefined;
    }
    renderLoading() {
        return (index.h("sc-card", { noPadding: true }, index.h("sc-stacked-list", null, index.h("sc-stacked-list-row", { style: { '--columns': '4' }, "mobile-size": 500 }, [...Array(4)].map(() => (index.h("sc-skeleton", { style: { width: '100px', display: 'inline-block' } })))))));
    }
    renderEmpty() {
        return (index.h("slot", { name: "empty" }, index.h("sc-card", null, index.h("sc-empty", { icon: "credit-card" }, wp.i18n.__('You do not have any payment methods.', 'surecart')))));
    }
    currentPaymentMethodId() {
        var _a, _b, _c, _d, _e;
        return ((_a = this.subscription) === null || _a === void 0 ? void 0 : _a.manual_payment)
            ? (_b = this.subscription) === null || _b === void 0 ? void 0 : _b.manual_payment_method
            : ((_d = (_c = this.subscription) === null || _c === void 0 ? void 0 : _c.payment_method) === null || _d === void 0 ? void 0 : _d.id) || ((_e = this.subscription) === null || _e === void 0 ? void 0 : _e.payment_method);
    }
    hasPaymentMethods() {
        var _a, _b;
        return ((_a = this.paymentMethods) === null || _a === void 0 ? void 0 : _a.length) && ((_b = this.manualPaymentMethods) === null || _b === void 0 ? void 0 : _b.length);
    }
    hasMultiplePaymentMethods() {
        var _a;
        return ((_a = [...((this === null || this === void 0 ? void 0 : this.paymentMethods) || []), ...((this === null || this === void 0 ? void 0 : this.manualPaymentMethods) || [])]) === null || _a === void 0 ? void 0 : _a.length) > 1;
    }
    componentWillLoad() {
        lazy.onFirstVisible(this.el, () => {
            this.getPaymentMethods();
        });
    }
    /** Get all subscriptions */
    async getPaymentMethods() {
        var _a, _b, _c;
        if (this.hasPaymentMethods())
            return;
        const customerId = ((_b = (_a = this.subscription) === null || _a === void 0 ? void 0 : _a.customer) === null || _b === void 0 ? void 0 : _b.id) || ((_c = this.subscription) === null || _c === void 0 ? void 0 : _c.customer);
        if (!customerId)
            return;
        try {
            this.loading = true;
            await this.fetchMethods(customerId);
        }
        catch (e) {
            this.error = (e === null || e === void 0 ? void 0 : e.messsage) || wp.i18n.__('Something went wrong', 'surecart');
            console.error(this.error);
        }
        finally {
            this.loading = false;
        }
    }
    async fetchMethods(customerId) {
        var _a, _b;
        this.paymentMethods = (await fetch.apiFetch({
            path: addQueryArgs.addQueryArgs(`surecart/v1/payment_methods`, {
                expand: ['card', 'customer', 'billing_agreement', 'paypal_account', 'payment_instrument', 'bank_account'],
                customer_ids: [customerId],
                reusable: true,
                live_mode: (_a = this.subscription) === null || _a === void 0 ? void 0 : _a.live_mode,
            }),
        }));
        this.manualPaymentMethods = (await fetch.apiFetch({
            path: addQueryArgs.addQueryArgs(`surecart/v1/manual_payment_methods`, {
                customer_ids: [customerId],
                reusable: true,
                live_mode: (_b = this.subscription) === null || _b === void 0 ? void 0 : _b.live_mode,
            }),
        }));
    }
    async deleteMethod(method) {
        const r = confirm(wp.i18n.__('Are you sure you want to remove this payment method?', 'surecart'));
        if (!r)
            return;
        try {
            this.busy = true;
            (await fetch.apiFetch({
                path: `surecart/v1/payment_methods/${method === null || method === void 0 ? void 0 : method.id}/detach`,
                method: 'PATCH',
            }));
            // remove from view.
            this.paymentMethods = this.paymentMethods.filter(m => m.id !== method.id);
        }
        catch (e) {
            this.error = (e === null || e === void 0 ? void 0 : e.messsage) || wp.i18n.__('Something went wrong', 'surecart');
            console.error(this.error);
        }
        finally {
            this.busy = false;
        }
    }
    async updateMethod(e) {
        var _a, _b;
        const { payment_method } = await e.target.getFormJson();
        if (payment_method === this.currentPaymentMethodId()) {
            return;
        }
        try {
            const isManualPaymentMethod = (this.manualPaymentMethods || []).some(method => method.id === payment_method);
            this.busy = true;
            this.subscription = (await fetch.apiFetch({
                path: `surecart/v1/subscriptions/${(_a = this.subscription) === null || _a === void 0 ? void 0 : _a.id}`,
                method: 'PATCH',
                data: {
                    ...(!isManualPaymentMethod ? { payment_method, manual_payment: false } : { manual_payment_method: payment_method, manual_payment: true }),
                },
            }));
            // redirect to edit page.
            window.location.assign(addQueryArgs.addQueryArgs(window.location.href, {
                action: 'edit',
                model: 'subscription',
                id: (_b = this.subscription) === null || _b === void 0 ? void 0 : _b.id,
            }));
            // remove from view.
        }
        catch (e) {
            this.error = (e === null || e === void 0 ? void 0 : e.messsage) || wp.i18n.__('Something went wrong', 'surecart');
            console.error(this.error);
        }
        finally {
            this.busy = false;
        }
    }
    renderContent() {
        var _a, _b;
        if (this.loading) {
            return this.renderLoading();
        }
        if (!((_a = this.paymentMethods) === null || _a === void 0 ? void 0 : _a.length) && !((_b = this.manualPaymentMethods) === null || _b === void 0 ? void 0 : _b.length)) {
            return this.renderEmpty();
        }
        return (index.h("sc-form", { onScSubmit: e => this.updateMethod(e) }, index.h("sc-choices", null, this.renderList()), this.hasMultiplePaymentMethods() && (index.h("sc-button", { type: "primary", submit: true, full: true, size: "large", busy: this.busy, disabled: this.busy }, wp.i18n.__('Update Payment Method', 'surecart')))));
    }
    renderList() {
        const regularPaymentMethods = this.paymentMethods.map(paymentMethod => {
            const { id, card, live_mode, paypal_account } = paymentMethod;
            return (index.h("sc-choice", { checked: this.currentPaymentMethodId() === id, name: "payment_method", value: id, required: true }, index.h("sc-flex", { justifyContent: "flex-start", "align-items": "center" }, index.h("sc-payment-method", { paymentMethod: paymentMethod }), ' ', !live_mode && (index.h("sc-tag", { type: "warning", size: "small" }, wp.i18n.__('Test', 'surecart')))), index.h("div", { slot: "description" }, !!(card === null || card === void 0 ? void 0 : card.exp_month) && (index.h("span", null, 
            /** Translators: Credit Card Expires (Exp. 11/27) */
            wp.i18n.__('Exp.', 'surecart'), card === null || card === void 0 ? void 0 :
                card.exp_month, "/", card === null || card === void 0 ? void 0 :
                card.exp_year)), !!paypal_account && (paypal_account === null || paypal_account === void 0 ? void 0 : paypal_account.email)), this.currentPaymentMethodId() === id && (index.h("sc-tag", { type: "info", slot: "price" }, wp.i18n.__('Current Payment Method', 'surecart')))));
        });
        const manualPaymentMethods = this.manualPaymentMethods.map(paymentMethod => {
            const { id } = paymentMethod;
            return (index.h("sc-choice", { checked: this.currentPaymentMethodId() === id, name: "payment_method", value: id, required: true }, index.h("sc-flex", { justifyContent: "flex-start", "align-items": "center" }, index.h("sc-manual-payment-method", { paymentMethod: paymentMethod, showDescription: true })), this.currentPaymentMethodId() === id && (index.h("sc-tag", { type: "info", slot: "price" }, wp.i18n.__('Current Payment Method', 'surecart')))));
        });
        return [...regularPaymentMethods, ...manualPaymentMethods];
    }
    render() {
        var _a;
        return (index.h("sc-dashboard-module", { key: '8d937b71f84742d2278fbf33ea50889222835654', heading: this.heading || wp.i18n.__('Update Payment Method', 'surecart'), class: "subscription", error: this.error }, index.h("sc-button", { key: '15ad250980256f2e75b95a82201fe40a11fd34d6', slot: "end", type: "link", href: addQueryArgs.addQueryArgs(window.location.href, {
                action: 'create',
                model: 'payment_method',
                ...(((_a = this.subscription) === null || _a === void 0 ? void 0 : _a.live_mode) === false ? { live_mode: false } : {}),
                success_url: window.location.href,
            }) }, index.h("sc-icon", { key: 'e9ad5763b95d50e0b578b1a1780c417398b14ea4', name: "plus", slot: "prefix" }), wp.i18n.__('Add New', 'surecart')), this.renderContent(), this.busy && index.h("sc-block-ui", { key: '88c88021ead6ff585220e813597105c154b0b429', spinner: true })));
    }
    get el() { return index.getElement(this); }
};
ScSubscriptionPaymentMethod.style = ScSubscriptionPaymentMethodStyle0;

exports.sc_subscription_payment_method = ScSubscriptionPaymentMethod;

//# sourceMappingURL=sc-subscription-payment-method.cjs.entry.js.map