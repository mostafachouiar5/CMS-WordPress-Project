import { r as registerInstance, c as createEvent, h } from './index-745b6bec.js';
import { a as getValueFromUrl } from './util-50af2a83.js';
import { s as state$1 } from './store-a8bae355.js';
import { s as state, o as onChange } from './mutations-d5e8faea.js';
import { c as createOrUpdateCheckout } from './index-96490395.js';
import './index-06061d4e.js';
import './utils-e9ee502a.js';
import './remove-query-args-938c53ea.js';
import './add-query-args-0e2a8393.js';
import './index-c5a96d53.js';
import './google-a86aa761.js';
import './currency-a0c9bff4.js';
import './store-7020541e.js';
import './price-d5770168.js';
import './fetch-2032d11d.js';

const scCustomerFirstnameCss = ":host{display:block}";
const ScCustomerFirstnameStyle0 = scCustomerFirstnameCss;

const ScCustomerFirstname = class {
    constructor(hostRef) {
        registerInstance(this, hostRef);
        this.scChange = createEvent(this, "scChange", 7);
        this.scUpdateOrderState = createEvent(this, "scUpdateOrderState", 7);
        this.scClear = createEvent(this, "scClear", 7);
        this.scInput = createEvent(this, "scInput", 7);
        this.scFocus = createEvent(this, "scFocus", 7);
        this.scBlur = createEvent(this, "scBlur", 7);
        this.scUpdateCustomer = createEvent(this, "scUpdateCustomer", 7);
        this.loggedIn = undefined;
        this.size = 'medium';
        this.value = getValueFromUrl('first_name');
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
    async reportValidity() {
        return this.input.reportValidity();
    }
    /** Silently update the checkout when the input changes. */
    async handleChange() {
        this.value = this.input.value;
        try {
            state.checkout = (await createOrUpdateCheckout({ id: state.checkout.id, data: { first_name: this.input.value } }));
        }
        catch (error) {
            console.error(error);
        }
    }
    /** Sync customer first name with session if it's updated by other means */
    handleSessionChange() {
        var _a, _b, _c, _d, _e, _f;
        //return if we already have a value
        if (this.value)
            return;
        const fromUrl = getValueFromUrl('first_name');
        if (!state$1.loggedIn && !!fromUrl) {
            this.value = fromUrl;
            return;
        }
        if (!state$1.loggedIn) {
            this.value = ((_b = (_a = state === null || state === void 0 ? void 0 : state.checkout) === null || _a === void 0 ? void 0 : _a.customer) === null || _b === void 0 ? void 0 : _b.first_name) || ((_c = state === null || state === void 0 ? void 0 : state.checkout) === null || _c === void 0 ? void 0 : _c.first_name);
        }
        else {
            this.value = ((_d = state === null || state === void 0 ? void 0 : state.checkout) === null || _d === void 0 ? void 0 : _d.first_name) || ((_f = (_e = state === null || state === void 0 ? void 0 : state.checkout) === null || _e === void 0 ? void 0 : _e.customer) === null || _f === void 0 ? void 0 : _f.first_name);
        }
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
    render() {
        return (h("sc-input", { key: '430e820b69b4750f5e8d51afbafbc3163b53bf8c', type: "text", name: "first_name", ref: el => (this.input = el), value: this.value, label: this.label, help: this.help, autocomplete: "first_name", placeholder: this.placeholder, readonly: this.readonly, required: this.required, invalid: this.invalid, autofocus: this.autofocus, hasFocus: this.hasFocus, onScChange: () => this.handleChange(), onScInput: () => this.scInput.emit(), onScFocus: () => this.scFocus.emit(), onScBlur: () => this.scBlur.emit(), ...(this.disabled && { disabled: true }) }));
    }
};
ScCustomerFirstname.style = ScCustomerFirstnameStyle0;

export { ScCustomerFirstname as sc_customer_firstname };

//# sourceMappingURL=sc-customer-firstname.entry.js.map