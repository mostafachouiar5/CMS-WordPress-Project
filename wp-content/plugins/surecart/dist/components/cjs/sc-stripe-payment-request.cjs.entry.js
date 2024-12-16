'use strict';

Object.defineProperty(exports, '__esModule', { value: true });

const index = require('./index-8acc3c89.js');
const pure = require('./pure-bd6f0a6e.js');
const mutations = require('./mutations-19357660.js');
const index$1 = require('./index-771f480e.js');
const mutations$1 = require('./mutations-11c8f9a8.js');
const consumer = require('./consumer-9f4ee0e3.js');
require('./index-bcdafe6e.js');
require('./utils-ee1bb9d3.js');
require('./remove-query-args-b57e8cd3.js');
require('./add-query-args-49dcb630.js');
require('./index-fb76df07.js');
require('./google-59d23803.js');
require('./currency-71fce0f0.js');
require('./store-1fb3d249.js');
require('./price-653ec1cb.js');
require('./fetch-f25a0cb0.js');

const scStripePaymentRequestCss = ":host{display:block}.or{display:none;margin:var(--sc-form-section-spacing) 0}.request--loaded .or{display:block}";
const ScStripePaymentRequestStyle0 = scStripePaymentRequestCss;

const ScStripePaymentRequest = class {
    constructor(hostRef) {
        index.registerInstance(this, hostRef);
        this.scFormSubmit = index.createEvent(this, "scFormSubmit", 7);
        this.scPaid = index.createEvent(this, "scPaid", 7);
        this.scPayError = index.createEvent(this, "scPayError", 7);
        this.scSetState = index.createEvent(this, "scSetState", 7);
        this.scPaymentRequestLoaded = index.createEvent(this, "scPaymentRequestLoaded", 7);
        this.scUpdateOrderState = index.createEvent(this, "scUpdateOrderState", 7);
        this.stripeAccountId = undefined;
        this.publishableKey = undefined;
        this.country = 'US';
        this.prices = undefined;
        this.label = 'total';
        this.amount = 0;
        this.theme = 'dark';
        this.error = undefined;
        this.debug = false;
        this.loaded = false;
        this.debugError = undefined;
    }
    async componentWillLoad() {
        if (!(this === null || this === void 0 ? void 0 : this.publishableKey) || !(this === null || this === void 0 ? void 0 : this.stripeAccountId)) {
            return true;
        }
        try {
            this.stripe = await pure.pure.loadStripe(this.publishableKey, { stripeAccount: this.stripeAccountId });
            this.elements = this.stripe.elements();
            this.paymentRequest = this.stripe.paymentRequest({
                country: this.country,
                requestShipping: true,
                requestPayerEmail: true,
                shippingOptions: [
                    {
                        id: 'free',
                        label: 'Free Shipping',
                        detail: 'No shipping required',
                        amount: 0,
                    },
                ],
                ...this.getRequestObject(mutations.state === null || mutations.state === void 0 ? void 0 : mutations.state.checkout),
            });
        }
        catch (e) {
            console.log((e === null || e === void 0 ? void 0 : e.message) || wp.i18n.__('Stripe could not be loaded', 'surecart'));
        }
    }
    handleOrderChange() {
        if (!this.paymentRequest)
            return;
        if (this.pendingEvent)
            return;
        this.paymentRequest.update(this.getRequestObject(mutations.state === null || mutations.state === void 0 ? void 0 : mutations.state.checkout));
    }
    handleLoaded() {
        this.scPaymentRequestLoaded.emit(true);
    }
    handleErrorChange() {
        if (this.pendingEvent) {
            this.pendingEvent.complete('error');
        }
    }
    async handleShippingChange(ev) {
        var _a, _b, _c, _d, _e;
        const { shippingAddress, updateWith } = ev;
        try {
            const order = (await index$1.createOrUpdateCheckout({
                id: (_a = mutations.state === null || mutations.state === void 0 ? void 0 : mutations.state.checkout) === null || _a === void 0 ? void 0 : _a.id,
                data: {
                    shipping_address: {
                        ...((shippingAddress === null || shippingAddress === void 0 ? void 0 : shippingAddress.name) ? { name: shippingAddress === null || shippingAddress === void 0 ? void 0 : shippingAddress.name } : {}),
                        ...(((_b = shippingAddress === null || shippingAddress === void 0 ? void 0 : shippingAddress.addressLine) === null || _b === void 0 ? void 0 : _b[0]) ? { line_1: (_c = shippingAddress === null || shippingAddress === void 0 ? void 0 : shippingAddress.addressLine) === null || _c === void 0 ? void 0 : _c[0] } : {}),
                        ...(((_d = shippingAddress === null || shippingAddress === void 0 ? void 0 : shippingAddress.addressLine) === null || _d === void 0 ? void 0 : _d[1]) ? { line_2: (_e = shippingAddress === null || shippingAddress === void 0 ? void 0 : shippingAddress.addressLine) === null || _e === void 0 ? void 0 : _e[1] } : {}),
                        ...((shippingAddress === null || shippingAddress === void 0 ? void 0 : shippingAddress.city) ? { city: shippingAddress === null || shippingAddress === void 0 ? void 0 : shippingAddress.city } : {}),
                        ...((shippingAddress === null || shippingAddress === void 0 ? void 0 : shippingAddress.country) ? { country: shippingAddress === null || shippingAddress === void 0 ? void 0 : shippingAddress.country } : {}),
                        ...((shippingAddress === null || shippingAddress === void 0 ? void 0 : shippingAddress.postalCode) ? { postal_code: shippingAddress === null || shippingAddress === void 0 ? void 0 : shippingAddress.postalCode } : {}),
                        ...((shippingAddress === null || shippingAddress === void 0 ? void 0 : shippingAddress.region) ? { state: shippingAddress === null || shippingAddress === void 0 ? void 0 : shippingAddress.region } : {}),
                    },
                },
            }));
            updateWith({
                status: 'success',
                total: {
                    amount: (order === null || order === void 0 ? void 0 : order.amount_due) || 0,
                    label: wp.i18n.__('Total', 'surecart'),
                    pending: true,
                },
            });
        }
        catch (e) {
            e.updateWith({ status: 'invalid_shipping_address' });
        }
    }
    /** Only append price name if there's more than one product price in the session. */
    getName(item) {
        var _a, _b, _c, _d, _e;
        const otherPrices = Object.keys(this.prices || {}).filter(key => {
            const price = this.prices[key];
            // @ts-ignore
            return price.product === item.price.product.id;
        });
        let name = '';
        if (otherPrices.length > 1) {
            name = `${(_b = (_a = item === null || item === void 0 ? void 0 : item.price) === null || _a === void 0 ? void 0 : _a.product) === null || _b === void 0 ? void 0 : _b.name} \u2013 ${(_c = item === null || item === void 0 ? void 0 : item.price) === null || _c === void 0 ? void 0 : _c.name}`;
        }
        else {
            name = (_e = (_d = item === null || item === void 0 ? void 0 : item.price) === null || _d === void 0 ? void 0 : _d.product) === null || _e === void 0 ? void 0 : _e.name;
        }
        return name;
    }
    getRequestObject(order) {
        var _a;
        const displayItems = (((_a = order === null || order === void 0 ? void 0 : order.line_items) === null || _a === void 0 ? void 0 : _a.data) || []).map(item => {
            return {
                label: this.getName(item),
                amount: item.ad_hoc_amount !== null ? item.ad_hoc_amount : item.subtotal_amount,
            };
        });
        return {
            currency: mutations.state.currencyCode,
            total: {
                amount: (order === null || order === void 0 ? void 0 : order.amount_due) || 0,
                label: wp.i18n.__('Total', 'surecart'),
                pending: true,
            },
            displayItems,
        };
    }
    componentDidLoad() {
        this.handleOrderChange();
        this.removeCheckoutListener = mutations.onChange('checkout', () => this.handleOrderChange());
        if (!this.elements) {
            return;
        }
        const paymentRequestElement = this.elements.create('paymentRequestButton', {
            paymentRequest: this.paymentRequest,
            style: {
                paymentRequestButton: {
                    theme: this.theme,
                },
            },
        });
        // handle payment method.
        this.paymentRequest.on('paymentmethod', e => this.handlePaymentMethod(e));
        this.paymentRequest.on('shippingaddresschange', async (ev) => await this.handleShippingChange(ev));
        // mount button.
        this.paymentRequest
            .canMakePayment()
            .then(result => {
            if (!result) {
                if (location.protocol !== 'https:') {
                    if (this.debug) {
                        this.debugError = wp.i18n.__('You must serve this page over HTTPS to display express payment buttons.', 'surecart');
                    }
                    console.log('SSL needed to display payment buttons.');
                }
                else {
                    if (this.debug) {
                        this.debugError = wp.i18n.__('You do not have any wallets set up in your browser.', 'surecart');
                    }
                    console.log('No wallets available.');
                }
                return;
            }
            paymentRequestElement.mount(this.request);
            this.loaded = true;
        })
            .catch(e => {
            console.error(e);
        });
    }
    /** Handle the payment method. */
    async handlePaymentMethod(ev) {
        var _a, _b, _c, _d, _e;
        const { billing_details } = ev === null || ev === void 0 ? void 0 : ev.paymentMethod;
        const { shippingAddress } = ev;
        try {
            this.scSetState.emit('FINALIZE');
            // update session with shipping/billing
            (await index$1.createOrUpdateCheckout({
                id: (_a = mutations.state === null || mutations.state === void 0 ? void 0 : mutations.state.checkout) === null || _a === void 0 ? void 0 : _a.id,
                data: {
                    email: billing_details === null || billing_details === void 0 ? void 0 : billing_details.email,
                    name: billing_details === null || billing_details === void 0 ? void 0 : billing_details.name,
                    shipping_address: {
                        ...((shippingAddress === null || shippingAddress === void 0 ? void 0 : shippingAddress.name) ? { name: shippingAddress === null || shippingAddress === void 0 ? void 0 : shippingAddress.name } : {}),
                        ...(((_b = shippingAddress === null || shippingAddress === void 0 ? void 0 : shippingAddress.addressLine) === null || _b === void 0 ? void 0 : _b[0]) ? { line_1: (_c = shippingAddress === null || shippingAddress === void 0 ? void 0 : shippingAddress.addressLine) === null || _c === void 0 ? void 0 : _c[0] } : {}),
                        ...(((_d = shippingAddress === null || shippingAddress === void 0 ? void 0 : shippingAddress.addressLine) === null || _d === void 0 ? void 0 : _d[1]) ? { line_2: (_e = shippingAddress === null || shippingAddress === void 0 ? void 0 : shippingAddress.addressLine) === null || _e === void 0 ? void 0 : _e[1] } : {}),
                        ...((shippingAddress === null || shippingAddress === void 0 ? void 0 : shippingAddress.city) ? { city: shippingAddress === null || shippingAddress === void 0 ? void 0 : shippingAddress.city } : {}),
                        ...((shippingAddress === null || shippingAddress === void 0 ? void 0 : shippingAddress.country) ? { country: shippingAddress === null || shippingAddress === void 0 ? void 0 : shippingAddress.country } : {}),
                        ...((shippingAddress === null || shippingAddress === void 0 ? void 0 : shippingAddress.postalCode) ? { postal_code: shippingAddress === null || shippingAddress === void 0 ? void 0 : shippingAddress.postalCode } : {}),
                        ...((shippingAddress === null || shippingAddress === void 0 ? void 0 : shippingAddress.region) ? { state: shippingAddress === null || shippingAddress === void 0 ? void 0 : shippingAddress.region } : {}),
                    },
                },
            }));
            // finalize
            const session = (await index$1.finalizeCheckout({
                id: mutations.state === null || mutations.state === void 0 ? void 0 : mutations.state.checkout.id,
                query: {
                    form_id: mutations.state.formId,
                },
                processor: { id: 'stripe', manual: false },
            }));
            // confirm payment
            this.scSetState.emit('PAYING');
            await this.confirmPayment(session, ev);
            this.scSetState.emit('PAID');
            // paid.
            this.scPaid.emit();
            // Report to the browser that the confirmation was successful, prompting
            // it to close the browser payment method collection interface.
            ev.complete('success');
        }
        catch (e) {
            console.error(e);
            this.scPayError.emit(e);
            mutations$1.createErrorNotice(e);
            ev.complete('fail');
        }
        finally {
            this.confirming = false;
        }
    }
    async confirmPayment(val, ev) {
        var _a, _b, _c, _d, _e, _f, _g, _h, _j, _k, _l, _m, _o, _p, _q, _r, _s, _t;
        // must be finalized
        if ((val === null || val === void 0 ? void 0 : val.status) !== 'finalized')
            return;
        // must have a secret
        if (!((_c = (_b = (_a = val === null || val === void 0 ? void 0 : val.payment_intent) === null || _a === void 0 ? void 0 : _a.processor_data) === null || _b === void 0 ? void 0 : _b.stripe) === null || _c === void 0 ? void 0 : _c.client_secret))
            return;
        // need an external_type
        if (!((_f = (_e = (_d = val === null || val === void 0 ? void 0 : val.payment_intent) === null || _d === void 0 ? void 0 : _d.processor_data) === null || _e === void 0 ? void 0 : _e.stripe) === null || _f === void 0 ? void 0 : _f.type))
            return;
        // must have an external intent id
        if (!((_g = val === null || val === void 0 ? void 0 : val.payment_intent) === null || _g === void 0 ? void 0 : _g.external_intent_id))
            return;
        // prevent possible double-charges
        if (this.confirming)
            return;
        this.confirming = true;
        let response;
        if (((_k = (_j = (_h = val === null || val === void 0 ? void 0 : val.payment_intent) === null || _h === void 0 ? void 0 : _h.processor_data) === null || _j === void 0 ? void 0 : _j.stripe) === null || _k === void 0 ? void 0 : _k.type) == 'setup') {
            response = await this.confirmCardSetup((_m = (_l = val === null || val === void 0 ? void 0 : val.payment_intent) === null || _l === void 0 ? void 0 : _l.processor_data) === null || _m === void 0 ? void 0 : _m.stripe.client_secret, ev);
        }
        else {
            response = await this.confirmCardPayment((_p = (_o = val === null || val === void 0 ? void 0 : val.payment_intent) === null || _o === void 0 ? void 0 : _o.processor_data) === null || _p === void 0 ? void 0 : _p.stripe.client_secret, ev);
        }
        if (response === null || response === void 0 ? void 0 : response.error) {
            throw response.error;
        }
        // Check if the PaymentIntent requires any actions and if so let Stripe.js
        // handle the flow. If using an API version older than "2019-02-11"
        // instead check for: `paymentIntent.status === "requires_source_action"`.
        if (((_q = response === null || response === void 0 ? void 0 : response.paymentIntent) === null || _q === void 0 ? void 0 : _q.status) === 'requires_action' || ((_r = response === null || response === void 0 ? void 0 : response.paymentIntent) === null || _r === void 0 ? void 0 : _r.status) === 'requires_source_action') {
            // Let Stripe.js handle the rest of the payment flow.
            const result = await this.stripe.confirmCardPayment((_t = (_s = val === null || val === void 0 ? void 0 : val.payment_intent) === null || _s === void 0 ? void 0 : _s.processor_data) === null || _t === void 0 ? void 0 : _t.stripe.client_secret);
            // The payment failed -- ask your customer for a new payment method.
            if (result.error) {
                throw result.error;
            }
            return result;
        }
        return response;
    }
    /** Confirm card payment. */
    confirmCardPayment(secret, ev) {
        return this.stripe.confirmCardPayment(secret, { payment_method: ev.paymentMethod.id }, { handleActions: false });
    }
    /** Confirm card setup. */
    confirmCardSetup(secret, ev) {
        return this.stripe.confirmCardSetup(secret, { payment_method: ev.paymentMethod.id }, { handleActions: false });
    }
    disconnectedCallback() {
        this.removeCheckoutListener();
    }
    render() {
        return (index.h("div", { key: 'd414e88afb388719cbf3a77840fd7a605105b1fc', class: { 'request': true, 'request--loaded': this.loaded } }, this.debug && this.debugError && (index.h("div", { key: '8738a17c454c8d7eab7a3dcc9998e2cd47d67371' }, index.h("slot", { key: 'aeb850ac61ca83b47da4cddbefe6caab1fe10e74', name: "debug-fallback" }), index.h("sc-alert", { key: '223e01fa342f2bce3ebae533bf822bd664a19f72', type: "info", open: true }, index.h("span", { key: '61ca5888c3f4d0970263b9746a064e7150ef38ff', slot: "title" }, wp.i18n.__('Express Payment', 'surecart')), this.debugError))), index.h("div", { key: '6eb45e52cc8fc07065227bdd565e0a79646a0454', class: "sc-payment-request-button", part: "button", ref: el => (this.request = el) })));
    }
    get el() { return index.getElement(this); }
    static get watchers() { return {
        "loaded": ["handleLoaded"],
        "error": ["handleErrorChange"]
    }; }
};
consumer.openWormhole(ScStripePaymentRequest, ['prices'], false);
ScStripePaymentRequest.style = ScStripePaymentRequestStyle0;

exports.sc_stripe_payment_request = ScStripePaymentRequest;

//# sourceMappingURL=sc-stripe-payment-request.cjs.entry.js.map