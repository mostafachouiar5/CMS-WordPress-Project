'use strict';

Object.defineProperty(exports, '__esModule', { value: true });

const index = require('./index-8acc3c89.js');
const functions = require('./functions-b63256c8.js');
const fetch = require('./fetch-f25a0cb0.js');
const index$1 = require('./index-771f480e.js');
const mutations = require('./mutations-11c8f9a8.js');
require('./add-query-args-49dcb630.js');
require('./remove-query-args-b57e8cd3.js');
require('./mutations-19357660.js');
require('./index-bcdafe6e.js');
require('./utils-ee1bb9d3.js');
require('./index-fb76df07.js');
require('./google-59d23803.js');
require('./currency-71fce0f0.js');
require('./store-1fb3d249.js');
require('./price-653ec1cb.js');

const paypalButtonsCss = ":host{display:block}.paypal-buttons{position:relative;line-height:0;text-align:center}.paypal-buttons:not(.paypal-buttons--busy):after{content:\" \";border-bottom:1px solid var(--sc-input-border-color);width:100%;height:0;top:50%;left:0;right:0;position:absolute}";
const ScPaypalButtonsStyle0 = paypalButtonsCss;

const ScPaypalButtons = class {
    constructor(hostRef) {
        index.registerInstance(this, hostRef);
        this.scSetState = index.createEvent(this, "scSetState", 7);
        this.scPaid = index.createEvent(this, "scPaid", 7);
        this.clientId = undefined;
        this.busy = false;
        this.merchantId = undefined;
        this.merchantInitiated = undefined;
        this.mode = undefined;
        this.order = undefined;
        this.buttons = ['paypal', 'card'];
        this.label = 'paypal';
        this.color = 'gold';
        this.loaded = undefined;
    }
    handleOrderChange(val, prev) {
        if ((val === null || val === void 0 ? void 0 : val.updated_at) === (prev === null || prev === void 0 ? void 0 : prev.updated_at)) {
            return;
        }
        this.cardContainer.innerHTML = '';
        this.paypalContainer.innerHTML = '';
        this.loadScript();
    }
    /** Load the script */
    async loadScript() {
        var _a, _b;
        if (!this.clientId || !this.merchantId)
            return;
        try {
            const paypal = await functions.loadScript(functions.getScriptLoadParams({
                clientId: this.clientId,
                merchantId: this.merchantId,
                merchantInitiated: this.merchantInitiated,
                reusable: (_a = this.order) === null || _a === void 0 ? void 0 : _a.reusable_payment_method_required,
                currency: (_b = this.order) === null || _b === void 0 ? void 0 : _b.currency,
            }));
            this.renderButtons(paypal);
        }
        catch (err) {
            console.error('failed to load the PayPal JS SDK script', err);
        }
    }
    /** Load the script on component load. */
    componentDidLoad() {
        this.loadScript();
    }
    /** Render the buttons. */
    renderButtons(paypal) {
        const createFunc = this.order.reusable_payment_method_required ? 'createBillingAgreement' : 'createOrder';
        const config = {
            /**
             * Validate the form, client-side when the button is clicked.
             */
            onClick: async (_, actions) => {
                const form = this.el.closest('sc-checkout');
                const isValid = await form.validate();
                return isValid ? actions.resolve() : actions.reject();
            },
            onInit: () => {
                this.loaded = true;
            },
            onCancel: () => {
                this.scSetState.emit('REJECT');
            },
            /**
             * The transaction has been approved.
             * We can capture it.
             */
            onApprove: async () => {
                var _a, _b, _c, _d;
                try {
                    this.order = (await index$1.fetchCheckout({ id: (_a = this.order) === null || _a === void 0 ? void 0 : _a.id }));
                }
                catch (e) {
                    console.error(e);
                    mutations.createErrorNotice({ code: 'could_not_capture', message: wp.i18n.__('The payment did not process. Please try again.', 'surecart') });
                    this.scSetState.emit('REJECT');
                }
                try {
                    this.scSetState.emit('PAYING');
                    const intent = (await fetch.apiFetch({
                        method: 'PATCH',
                        path: `surecart/v1/payment_intents/${((_c = (_b = this.order) === null || _b === void 0 ? void 0 : _b.payment_intent) === null || _c === void 0 ? void 0 : _c.id) || ((_d = this.order) === null || _d === void 0 ? void 0 : _d.payment_intent)}/capture`,
                    }));
                    if (['succeeded', 'processing'].includes(intent === null || intent === void 0 ? void 0 : intent.status)) {
                        this.scSetState.emit('PAID');
                        this.scPaid.emit();
                    }
                    else {
                        mutations.createErrorNotice({ code: 'could_not_capture', message: wp.i18n.__('Payment processing failed. Kindly attempt the transaction once more.', 'surecart') });
                        this.scSetState.emit('REJECT');
                    }
                }
                catch (err) {
                    console.error(err);
                    mutations.createErrorNotice({ code: 'could_not_capture', message: wp.i18n.__('Payment processing failed. Kindly attempt the transaction once more.', 'surecart') });
                    this.scSetState.emit('REJECT');
                }
            },
            /**
             * Transaction errored.
             * @param err
             */
            onError: err => {
                console.error(err);
                mutations.createErrorNotice(err);
                this.scSetState.emit('REJECT');
            },
        };
        config[createFunc] = async () => {
            return new Promise(async (resolve, reject) => {
                var _a, _b;
                // get the checkout component.
                const checkout = this.el.closest('sc-checkout');
                // submit and get the finalized order
                const order = (await checkout.submit());
                // an error occurred. reject with the error.
                if (order instanceof Error) {
                    return reject(order);
                }
                // assume there was a validation issue here.
                // that is handled by our fetch function.
                if ((order === null || order === void 0 ? void 0 : order.status) !== 'finalized') {
                    return reject(new Error('Something went wrong. Please try again.'));
                }
                // resolve the payment intent id.
                if ((_a = order === null || order === void 0 ? void 0 : order.payment_intent) === null || _a === void 0 ? void 0 : _a.external_intent_id) {
                    return resolve((_b = order === null || order === void 0 ? void 0 : order.payment_intent) === null || _b === void 0 ? void 0 : _b.external_intent_id);
                }
                // we don't have the correct payment intent for some reason.
                mutations.createErrorNotice({ code: 'missing_payment_intent', message: wp.i18n.__('Something went wrong. Please contact us for payment.', 'surecart') });
                return reject();
            });
        };
        if (paypal.FUNDING.PAYPAL) {
            const paypalButton = paypal.Buttons({
                fundingSource: paypal.FUNDING.PAYPAL,
                style: {
                    label: this.label,
                    color: this.color,
                },
                ...config,
            });
            if (paypalButton.isEligible()) {
                paypalButton.render(this.paypalContainer);
            }
        }
        if (paypal.FUNDING.CARD) {
            const cardButton = paypal.Buttons({
                fundingSource: paypal.FUNDING.CARD,
                style: {
                    color: 'black',
                },
                ...config,
            });
            if (cardButton.isEligible()) {
                cardButton.render(this.cardContainer);
            }
        }
    }
    render() {
        return (index.h("div", { key: 'd1e63c677a0d3d0fdab043cd542469fc9c3465c7', part: `base ${this.busy || (!this.loaded && 'base--busy')}`, class: { 'paypal-buttons': true, 'paypal-buttons--busy': this.busy || !this.loaded } }, (!this.loaded || this.busy) && index.h("sc-skeleton", { key: 'a74e15cd048dadce00e76e4cbea075822ebc04aa', style: { 'height': '55px', '--border-radius': '4px', 'cursor': 'wait' } }), index.h("div", { key: '8817949118eb44b6d95f34135a20c45a54c1d5d4', class: "sc-paypal-button-container", hidden: !this.loaded || this.busy }, index.h("div", { key: '42f52782520d13a055885c6630e73c810de02a21', part: "paypal-card-button", hidden: !this.buttons.includes('card'), class: "sc-paypal-card-button", ref: el => (this.cardContainer = el) }), index.h("div", { key: 'b7d6ca41a5b50f723ff07776854144f72c7710fa', part: "paypal-button", hidden: !this.buttons.includes('paypal'), class: "sc-paypal-button", ref: el => (this.paypalContainer = el) }))));
    }
    get el() { return index.getElement(this); }
    static get watchers() { return {
        "order": ["handleOrderChange"]
    }; }
};
ScPaypalButtons.style = ScPaypalButtonsStyle0;

const scSecureNoticeCss = ":host{display:block;--sc-secure-notice-icon-color:var(--sc-color-gray-300);--sc-secure-notice-font-size:var(--sc-font-size-small);--sc-secure-notice-color:var(--sc-color-gray-500)}.notice{color:var(--sc-secure-notice-color);font-size:var(--sc-secure-notice-font-size);display:flex;align-items:center;gap:5px}.notice__text{flex:1;display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap}.notice__icon{color:var(--sc-secure-notice-icon-color);margin-right:5px}";
const ScSecureNoticeStyle0 = scSecureNoticeCss;

const ScSecureNotice = class {
    constructor(hostRef) {
        index.registerInstance(this, hostRef);
    }
    render() {
        return (index.h("div", { key: '9ce5e850f8ff91b67041fb500d959e9f96b15ed9', class: "notice", part: "base" }, index.h("svg", { key: 'f2313b0bb8ff1ab0ba7d1ac28fb31b1d7dbe649f', class: "notice__icon", part: "icon", xmlns: "http://www.w3.org/2000/svg", width: "16", height: "16", viewBox: "0 0 512 512", fill: "currentColor" }, index.h("path", { key: '518d8e1d7cb62a059ad2d0098595006d6f80d063', d: "M368,192H352V112a96,96,0,1,0-192,0v80H144a64.07,64.07,0,0,0-64,64V432a64.07,64.07,0,0,0,64,64H368a64.07,64.07,0,0,0,64-64V256A64.07,64.07,0,0,0,368,192Zm-48,0H192V112a64,64,0,1,1,128,0Z" })), index.h("span", { key: '14323ee9e17b23ad3744862790ef9d80dbc5edaf', class: "notice__text", part: "text" }, index.h("slot", { key: '0fadcab795d9aa57be175983835146af40c45a3d', name: "prefix" }), index.h("slot", { key: 'c6bcc4f996f315ac762e568ed3a46114f6ec3fc9' }), index.h("slot", { key: '682b287e47bb3502e0cd091e884cd7b775372221', name: "suffix" }))));
    }
};
ScSecureNotice.style = ScSecureNoticeStyle0;

exports.sc_paypal_buttons = ScPaypalButtons;
exports.sc_secure_notice = ScSecureNotice;

//# sourceMappingURL=sc-paypal-buttons_2.cjs.entry.js.map