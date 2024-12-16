'use strict';

Object.defineProperty(exports, '__esModule', { value: true });

const index = require('./index-8acc3c89.js');
const fetch = require('./fetch-f25a0cb0.js');
const addQueryArgs = require('./add-query-args-49dcb630.js');
require('./remove-query-args-b57e8cd3.js');

const scMollieAddMethodCss = ":host{display:block}";
const ScMollieAddMethodStyle0 = scMollieAddMethodCss;

const ScMollieAddMethod = class {
    constructor(hostRef) {
        index.registerInstance(this, hostRef);
        this.country = undefined;
        this.successUrl = undefined;
        this.processorId = undefined;
        this.currency = undefined;
        this.liveMode = undefined;
        this.customerId = undefined;
        this.methods = [];
        this.loading = undefined;
        this.error = undefined;
        this.selectedMethodId = undefined;
        this.paymentIntent = undefined;
    }
    componentWillLoad() {
        this.fetchMethods();
    }
    async createPaymentIntent() {
        var _a, _b, _c, _d;
        try {
            this.loading = true;
            this.error = '';
            this.paymentIntent = await fetch.apiFetch({
                method: 'POST',
                path: 'surecart/v1/payment_intents',
                data: {
                    processor_type: 'mollie',
                    live_mode: this.liveMode,
                    customer_id: this.customerId,
                    return_url: this.successUrl,
                    payment_method_type: this.selectedMethodId,
                    currency: this.currency,
                    refresh_status: true,
                },
            });
            if ((_b = (_a = this.paymentIntent.processor_data) === null || _a === void 0 ? void 0 : _a.mollie) === null || _b === void 0 ? void 0 : _b.checkout_url) {
                window.location.assign((_d = (_c = this.paymentIntent.processor_data) === null || _c === void 0 ? void 0 : _c.mollie) === null || _d === void 0 ? void 0 : _d.checkout_url);
            }
        }
        catch (e) {
            console.error(e);
            this.error = (e === null || e === void 0 ? void 0 : e.message) || wp.i18n.__('Something went wrong', 'surecart');
            this.loading = false;
        }
    }
    async fetchMethods() {
        var _a, _b, _c;
        try {
            this.loading = true;
            const response = (await fetch.apiFetch({
                path: addQueryArgs.addQueryArgs(`surecart/v1/processors/${this.processorId}/payment_method_types`, {
                    amount: 2500,
                    country: this.country,
                    currency: this.currency,
                    reusable: true,
                }),
            }));
            this.methods = (response === null || response === void 0 ? void 0 : response.data) || [];
            if ((_a = this.methods) === null || _a === void 0 ? void 0 : _a.length) {
                this.selectedMethodId = (_c = (_b = this.methods) === null || _b === void 0 ? void 0 : _b[0]) === null || _c === void 0 ? void 0 : _c.id;
            }
        }
        catch (e) {
            this.error = (e === null || e === void 0 ? void 0 : e.message) || wp.i18n.__('Something went wrong', 'surecart');
            console.error(e);
        }
        finally {
            this.loading = false;
        }
    }
    handleSubmit() {
        this.createPaymentIntent();
    }
    renderLoading() {
        return (index.h("sc-card", null, index.h("sc-skeleton", { style: { width: '50%', marginBottom: '0.5em' } }), index.h("sc-skeleton", { style: { width: '30%', marginBottom: '0.5em' } }), index.h("sc-skeleton", { style: { width: '60%', marginBottom: '0.5em' } })));
    }
    render() {
        var _a;
        if (this.loading && !((_a = this.methods) === null || _a === void 0 ? void 0 : _a.length)) {
            return this.renderLoading();
        }
        return (index.h("sc-form", { onScFormSubmit: () => this.handleSubmit(), style: { position: 'relative' } }, index.h("sc-toggles", { collapsible: false, theme: "container" }, (this.methods || []).map(method => (index.h("sc-toggle", { "show-control": true, shady: true, borderless: true, open: this.selectedMethodId === (method === null || method === void 0 ? void 0 : method.id), onScShow: () => (this.selectedMethodId = method === null || method === void 0 ? void 0 : method.id) }, index.h("span", { slot: "summary", class: "sc-payment-toggle-summary" }, !!(method === null || method === void 0 ? void 0 : method.image) && index.h("img", { src: method === null || method === void 0 ? void 0 : method.image }), index.h("span", null, method === null || method === void 0 ? void 0 : method.description)), index.h("sc-card", null, index.h("sc-payment-selected", { label: wp.i18n.sprintf(wp.i18n.__('%s selected.', 'surecart'), method === null || method === void 0 ? void 0 : method.description) }, !!(method === null || method === void 0 ? void 0 : method.image) && index.h("img", { slot: "icon", src: method === null || method === void 0 ? void 0 : method.image, style: { width: '32px' } }), wp.i18n.__('Another step will appear after submitting your order to add this payment method.', 'surecart'))))))), index.h("sc-button", { type: "primary", submit: true, full: true, loading: this.loading }, wp.i18n.__('Add Payment Method', 'surecart')), this.loading && index.h("sc-block-ui", { "z-index": 9, style: { '--sc-block-ui-opacity': '0.75' } })));
    }
};
ScMollieAddMethod.style = ScMollieAddMethodStyle0;

exports.sc_mollie_add_method = ScMollieAddMethod;

//# sourceMappingURL=sc-mollie-add-method.cjs.entry.js.map