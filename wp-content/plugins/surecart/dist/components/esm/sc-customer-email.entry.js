import { r as registerInstance, c as createEvent, h, H as Host } from './index-745b6bec.js';
import { c as createOrUpdateCheckout } from './index-96490395.js';
import { a as getValueFromUrl } from './util-50af2a83.js';
import { s as state$1 } from './store-a8bae355.js';
import { s as state, o as onChange } from './mutations-d5e8faea.js';
import './fetch-2032d11d.js';
import './add-query-args-0e2a8393.js';
import './remove-query-args-938c53ea.js';
import './index-06061d4e.js';
import './utils-e9ee502a.js';
import './index-c5a96d53.js';
import './google-a86aa761.js';
import './currency-a0c9bff4.js';
import './store-7020541e.js';
import './price-d5770168.js';

const scCustomerEmailCss = ":host{display:block}a{color:var(--sc-color-primary-500)}a.customer-email__login-link{color:var(--sc-customer-login-link-color, var(--sc-input-placeholder-color));text-decoration:none;font-size:var(--sc-font-size-small)}.tracking-confirmation-message{font-size:var(--sc-font-size-xx-small)}.tracking-confirmation-message span{opacity:0.75}";
const ScCustomerEmailStyle0 = scCustomerEmailCss;

const ScCustomerEmail = class {
    constructor(hostRef) {
        registerInstance(this, hostRef);
        this.scChange = createEvent(this, "scChange", 7);
        this.scClear = createEvent(this, "scClear", 7);
        this.scInput = createEvent(this, "scInput", 7);
        this.scFocus = createEvent(this, "scFocus", 7);
        this.scBlur = createEvent(this, "scBlur", 7);
        this.scUpdateOrderState = createEvent(this, "scUpdateOrderState", 7);
        this.scUpdateAbandonedCart = createEvent(this, "scUpdateAbandonedCart", 7);
        this.scLoginPrompt = createEvent(this, "scLoginPrompt", 7);
        this.trackingConfirmationMessage = undefined;
        this.size = 'medium';
        this.value = getValueFromUrl('email');
        this.pill = false;
        this.label = undefined;
        this.showLabel = true;
        this.help = '';
        this.placeholder = undefined;
        this.disabled = false;
        this.readonly = false;
        this.required = false;
        this.invalid = false;
        this.autofocus = undefined;
        this.hasFocus = undefined;
    }
    async handleChange() {
        this.value = this.input.value;
        this.scChange.emit();
        try {
            state.checkout = (await createOrUpdateCheckout({ id: state.checkout.id, data: { email: this.input.value } }));
        }
        catch (error) {
            console.log(error);
        }
    }
    async reportValidity() {
        var _a, _b;
        return (_b = (_a = this.input) === null || _a === void 0 ? void 0 : _a.reportValidity) === null || _b === void 0 ? void 0 : _b.call(_a);
    }
    /** Sync customer email with session if it's updated by other means */
    handleSessionChange() {
        var _a, _b, _c, _d, _e, _f;
        // we already have a value and we are not yet logged in.
        if (this.value && !state$1.loggedIn)
            return;
        // we are logged in already.
        if (state$1.loggedIn) {
            // get email from user state fist.
            this.value = state$1.email || ((_b = (_a = state === null || state === void 0 ? void 0 : state.checkout) === null || _a === void 0 ? void 0 : _a.customer) === null || _b === void 0 ? void 0 : _b.email) || ((_c = state === null || state === void 0 ? void 0 : state.checkout) === null || _c === void 0 ? void 0 : _c.email);
            return;
        }
        const fromUrl = getValueFromUrl('email');
        if (!state$1.loggedIn && !!fromUrl) {
            this.value = fromUrl;
            return;
        }
        this.value = ((_d = state === null || state === void 0 ? void 0 : state.checkout) === null || _d === void 0 ? void 0 : _d.email) || ((_f = (_e = state === null || state === void 0 ? void 0 : state.checkout) === null || _e === void 0 ? void 0 : _e.customer) === null || _f === void 0 ? void 0 : _f.email);
    }
    /** Listen to checkout. */
    componentWillLoad() {
        this.handleSessionChange();
        this.removeCheckoutListener = onChange('checkout', () => this.handleSessionChange());
    }
    /** Remove listener. */
    disconnectedCallback() {
        this.removeCheckoutListener();
    }
    renderOptIn() {
        if (!this.trackingConfirmationMessage)
            return null;
        if (state.abandonedCheckoutEnabled !== false) {
            return (h("div", { class: "tracking-confirmation-message" }, h("span", null, this.trackingConfirmationMessage), ' ', h("a", { href: "#", onClick: e => {
                    e.preventDefault();
                    this.scUpdateAbandonedCart.emit(false);
                } }, wp.i18n.__('No Thanks', 'surecart'))));
        }
        return (h("div", { class: "tracking-confirmation-message" }, h("span", null, " ", wp.i18n.__("You won't receive further emails from us.", 'surecart'))));
    }
    render() {
        var _a;
        return (h(Host, { key: 'bc967aac9ef137a1aa3934eb69af1baea87c7179' }, h("sc-input", { key: '28c179e737e0286dda531acdf90c26531301d7de', exportparts: "base, input, form-control, label, help-text, prefix, suffix", type: "email", name: "email", ref: el => (this.input = el), value: this.value, help: this.help, label: this.label, autocomplete: 'email', placeholder: this.placeholder, disabled: this.disabled || (!!state$1.loggedIn && !!((_a = this.value) === null || _a === void 0 ? void 0 : _a.length) && !this.invalid), readonly: this.readonly, required: true, invalid: this.invalid, autofocus: this.autofocus, hasFocus: this.hasFocus, onScChange: () => this.handleChange(), onScInput: () => this.scInput.emit(), onScFocus: () => this.scFocus.emit(), onScBlur: () => this.scBlur.emit() }), this.renderOptIn()));
    }
};
ScCustomerEmail.style = ScCustomerEmailStyle0;

export { ScCustomerEmail as sc_customer_email };

//# sourceMappingURL=sc-customer-email.entry.js.map