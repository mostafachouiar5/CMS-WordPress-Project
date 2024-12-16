import { r as registerInstance, c as createEvent, h, F as Fragment, a as getElement } from './index-745b6bec.js';
import { p as pure } from './pure-963214cb.js';
import { o as openWormhole } from './consumer-e06b16d3.js';
import { s as state } from './watchers-38693c1f.js';
import { a as availableProcessors } from './getters-ff7a502e.js';
import { c as createErrorNotice } from './mutations-ed6d0770.js';
import { u as updateFormState } from './mutations-d5e8faea.js';
import './index-06061d4e.js';
import './util-50af2a83.js';
import './utils-e9ee502a.js';
import './index-c5a96d53.js';
import './remove-query-args-938c53ea.js';
import './add-query-args-0e2a8393.js';
import './google-a86aa761.js';
import './currency-a0c9bff4.js';
import './store-7020541e.js';
import './price-d5770168.js';

const scStripeElementCss = "sc-stripe-element{display:block;--focus-ring:0 0 0 var(--sc-focus-ring-width) var(--sc-focus-ring-color-primary)}sc-stripe-element sc-input{--sc-input-height-medium:auto}.sc-stripe *{font-family:var(--sc-input-font-family);font-weight:var(--sc-input-font-weight);font-size:var(--sc-input-font-size)}.sc-stripe-element{border-radius:var(--sc-input-border-radius-medium);font-size:var(--sc-input-font-size-medium);height:var(--sc-input-height-medium);width:100%;box-sizing:border-box !important;background-color:var(--sc-input-background-color);border:solid 1px var(--sc-input-border-color, var(--sc-input-border));box-shadow:var(--sc-input-box-shadow);transition:var(--sc-input-transition, var(--sc-transition-medium)) color, var(--sc-input-transition, var(--sc-transition-medium)) border, var(--sc-input-transition, var(--sc-transition-medium)) box-shadow}.sc-stripe-element:hover{background-color:var(--sc-input-background-color-hover);border-color:var(--sc-input-border-color-hover)}.sc-stripe-element.StripeElement--focus{background-color:var(--sc-input-background-color-focus);border-color:var(--sc-input-border-color-focus);box-shadow:var(--focus-ring)}.sc-stripe fieldset{margin:0 15px 20px;padding:0;border-style:none;background-color:#7795f8;box-shadow:0 6px 9px rgba(50, 50, 93, 0.06), 0 2px 5px rgba(0, 0, 0, 0.08), inset 0 1px 0 #829fff;border-radius:4px}.sc-stripe .row{display:-ms-flexbox;display:flex;-ms-flex-align:center;align-items:center;margin-left:15px}.sc-stripe .row+.row{border-top:1px solid #819efc}.sc-stripe label{width:15%;min-width:70px;padding:11px 0;color:#c4f0ff;overflow:hidden;text-overflow:ellipsis;white-space:nowrap}.sc-stripe input,.sc-stripe button{-webkit-appearance:none;-moz-appearance:none;appearance:none;outline:none;border-style:none}.sc-stripe input:-webkit-autofill{-webkit-text-fill-color:#fce883;transition:background-color 100000000s;-webkit-animation:1ms void-animation-out}.sc-stripe .StripeElement--webkit-autofill{background:transparent !important}.sc-stripe .StripeElement{width:100%;padding:var(--sc-input-spacing-small)}.sc-stripe input{width:100%;padding:11px;color:#fff;background-color:transparent;-webkit-animation:1ms void-animation-out}.sc-stripe input::-webkit-input-placeholder{color:#87bbfd}.sc-stripe input::-moz-placeholder{color:#87bbfd}.sc-stripe input:-ms-input-placeholder{color:#87bbfd}.sc-stripe button{display:block;width:calc(100% - 30px);height:40px;margin:40px 15px 0;background-color:#f6a4eb;box-shadow:0 6px 9px rgba(50, 50, 93, 0.06), 0 2px 5px rgba(0, 0, 0, 0.08), inset 0 1px 0 #ffb9f6;border-radius:4px;color:#fff;font-weight:600;cursor:pointer}.sc-stripe button:active{background-color:#d782d9;box-shadow:0 6px 9px rgba(50, 50, 93, 0.06), 0 2px 5px rgba(0, 0, 0, 0.08), inset 0 1px 0 #e298d8}.sc-stripe .error svg .base{fill:#fff}.sc-stripe .error svg .glyph{fill:#6772e5}.sc-stripe .error .message{color:#fff}.sc-stripe .success .icon .border{stroke:#87bbfd}.sc-stripe .success .icon .checkmark{stroke:#fff}.sc-stripe .success .title{color:#fff}.sc-stripe .success .message{color:#9cdbff}.sc-stripe .success .reset path{fill:#fff}";
const ScStripeElementStyle0 = scStripeElementCss;

const ScStripeElement = class {
    constructor(hostRef) {
        registerInstance(this, hostRef);
        this.scPaid = createEvent(this, "scPaid", 7);
        this.scSetState = createEvent(this, "scSetState", 7);
        this.scPaymentInfoAdded = createEvent(this, "scPaymentInfoAdded", 7);
        this.disabled = undefined;
        this.order = undefined;
        this.mode = 'live';
        this.size = 'medium';
        this.label = undefined;
        this.secureText = '';
        this.showLabel = true;
        this.hasFocus = undefined;
        this.selectedProcessorId = undefined;
        this.formState = undefined;
        this.error = undefined;
        this.confirming = undefined;
    }
    async componentWillLoad() {
        const processor = (availableProcessors() || []).find(processor => processor.processor_type === 'stripe');
        if (!processor) {
            return;
        }
        const { account_id, publishable_key } = (processor === null || processor === void 0 ? void 0 : processor.processor_data) || {};
        try {
            this.stripe = await pure.loadStripe(publishable_key, { stripeAccount: account_id });
            this.elements = this.stripe.elements();
        }
        catch (e) {
            this.error = (e === null || e === void 0 ? void 0 : e.message) || wp.i18n.__('Stripe could not be loaded', 'surecart');
        }
    }
    /**
     * Watch order status and maybe confirm the order.
     */
    async maybeConfirmOrder(val) {
        var _a, _b, _c, _d, _e, _f, _g, _h, _j, _k, _l, _m, _o, _p, _q, _r, _s, _t, _u, _v, _w, _x, _y;
        // must be paying
        if (val !== 'paying')
            return;
        // this processor is not selected.
        if ((state === null || state === void 0 ? void 0 : state.id) !== 'stripe')
            return;
        // must be a stripe session
        if (((_b = (_a = this.order) === null || _a === void 0 ? void 0 : _a.payment_intent) === null || _b === void 0 ? void 0 : _b.processor_type) !== 'stripe')
            return;
        // must have an external intent id
        if (!((_d = (_c = this.order) === null || _c === void 0 ? void 0 : _c.payment_intent) === null || _d === void 0 ? void 0 : _d.external_intent_id))
            return;
        // must have a secret
        if (!((_h = (_g = (_f = (_e = this.order) === null || _e === void 0 ? void 0 : _e.payment_intent) === null || _f === void 0 ? void 0 : _f.processor_data) === null || _g === void 0 ? void 0 : _g.stripe) === null || _h === void 0 ? void 0 : _h.client_secret))
            return;
        // need an external_type
        if (!((_m = (_l = (_k = (_j = this.order) === null || _j === void 0 ? void 0 : _j.payment_intent) === null || _k === void 0 ? void 0 : _k.processor_data) === null || _l === void 0 ? void 0 : _l.stripe) === null || _m === void 0 ? void 0 : _m.type))
            return;
        // prevent possible double-charges
        if (this.confirming)
            return;
        this.confirming = true;
        try {
            let response;
            if (((_r = (_q = (_p = (_o = this.order) === null || _o === void 0 ? void 0 : _o.payment_intent) === null || _p === void 0 ? void 0 : _p.processor_data) === null || _q === void 0 ? void 0 : _q.stripe) === null || _r === void 0 ? void 0 : _r.type) == 'setup') {
                response = await this.confirmCardSetup((_u = (_t = (_s = this.order) === null || _s === void 0 ? void 0 : _s.payment_intent) === null || _t === void 0 ? void 0 : _t.processor_data) === null || _u === void 0 ? void 0 : _u.stripe.client_secret);
            }
            else {
                response = await this.confirmCardPayment((_y = (_x = (_w = (_v = this.order) === null || _v === void 0 ? void 0 : _v.payment_intent) === null || _w === void 0 ? void 0 : _w.processor_data) === null || _x === void 0 ? void 0 : _x.stripe) === null || _y === void 0 ? void 0 : _y.client_secret);
            }
            if (response === null || response === void 0 ? void 0 : response.error) {
                this.error = response.error.message;
                throw response.error;
            }
            this.scSetState.emit('PAID');
            // paid
            this.scPaid.emit();
        }
        catch (e) {
            updateFormState('REJECT');
            createErrorNotice(e);
            if (e.message) {
                this.error = e.message;
            }
            this.confirming = false;
            this.scSetState.emit('REJECT');
        }
    }
    /** Confirm card payment */
    async confirmCardPayment(secret) {
        var _a, _b;
        return this.stripe.confirmCardPayment(secret, {
            payment_method: {
                card: this.element,
                billing_details: {
                    ...(((_a = this === null || this === void 0 ? void 0 : this.order) === null || _a === void 0 ? void 0 : _a.name) ? { name: this.order.name } : {}),
                    ...(((_b = this === null || this === void 0 ? void 0 : this.order) === null || _b === void 0 ? void 0 : _b.email) ? { email: this.order.email } : {}),
                },
            },
        });
    }
    /** Confirm card setup. */
    async confirmCardSetup(secret) {
        var _a, _b;
        return this.stripe.confirmCardSetup(secret, {
            payment_method: {
                card: this.element,
                billing_details: {
                    ...(((_a = this === null || this === void 0 ? void 0 : this.order) === null || _a === void 0 ? void 0 : _a.name) ? { name: this.order.name } : {}),
                    ...(((_b = this === null || this === void 0 ? void 0 : this.order) === null || _b === void 0 ? void 0 : _b.email) ? { email: this.order.email } : {}),
                },
            },
        });
    }
    componentDidLoad() {
        if (!this.elements) {
            return;
        }
        // get the computed styles.
        const styles = getComputedStyle(document.body);
        this.elements
            .create('card', {
            style: {
                base: {
                    'color': styles.getPropertyValue('--sc-input-label-color'),
                    'fontSize': '16px',
                    'iconColor': styles.getPropertyValue('--sc-stripe-icon-color'),
                    'fontSmoothing': 'antialiased',
                    '::placeholder': {
                        color: styles.getPropertyValue('--sc-input-placeholder-color'),
                    },
                },
                invalid: {
                    'color': styles.getPropertyValue('--sc-color-error-500'),
                    ':focus': {
                        color: styles.getPropertyValue('--sc-input-label-color'),
                    },
                },
            },
        })
            .mount(this.container);
        this.element = this.elements.getElement('card');
        this.element.on('change', (event) => {
            var _a, _b, _c;
            if (event.complete) {
                this.scPaymentInfoAdded.emit({
                    processor_type: 'stripe',
                    checkout_id: this.order.id,
                    currency: this.order.currency,
                    total_amount: this.order.total_amount,
                    line_items: this.order.line_items,
                    payment_method: {
                        billing_details: {
                            name: ((_a = this === null || this === void 0 ? void 0 : this.order) === null || _a === void 0 ? void 0 : _a.name) ? this.order.name : '',
                            email: ((_b = this === null || this === void 0 ? void 0 : this.order) === null || _b === void 0 ? void 0 : _b.email) ? this.order.email : '',
                        },
                    },
                });
            }
            this.error = ((_c = event === null || event === void 0 ? void 0 : event.error) === null || _c === void 0 ? void 0 : _c.message) ? event.error.message : '';
        });
        this.element.on('focus', () => (this.hasFocus = true));
        this.element.on('blur', () => (this.hasFocus = false));
    }
    render() {
        return (h(Fragment, { key: '926244e2aea64228f6bf56224434528501598e8a' }, h("sc-form-control", { key: 'b3073f73c7288b6d220857da0dadc2fe7f18b5b8', class: "sc-stripe", size: this.size, label: this.label }, h("div", { key: '44eb0c8c5e0ffa319ebf887937af0fcfc687f563', class: "sc-stripe-element", ref: el => (this.container = el) })), this.error && (h("sc-text", { key: '376ad99c6cc6ac7aa650d9ae0100ac8dc9c422c6', style: {
                'color': 'var(--sc-color-danger-500)',
                '--font-size': 'var(--sc-font-size-small)',
                'marginTop': '0.5em',
            } }, this.error))));
    }
    get el() { return getElement(this); }
    static get watchers() { return {
        "formState": ["maybeConfirmOrder"]
    }; }
};
openWormhole(ScStripeElement, ['order', 'mode', 'selectedProcessorId', 'formState'], false);
ScStripeElement.style = ScStripeElementStyle0;

export { ScStripeElement as sc_stripe_element };

//# sourceMappingURL=sc-stripe-element.entry.js.map