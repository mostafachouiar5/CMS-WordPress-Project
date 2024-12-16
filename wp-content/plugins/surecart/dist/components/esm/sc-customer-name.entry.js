import { r as registerInstance, c as createEvent, h } from './index-745b6bec.js';
import { c as createOrUpdateCheckout } from './index-96490395.js';
import { s as state$1 } from './store-a8bae355.js';
import { s as state, o as onChange } from './mutations-d5e8faea.js';
import { a as getValueFromUrl } from './util-50af2a83.js';
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

const scCustomerNameCss = ":host{display:block}";
const ScCustomerNameStyle0 = scCustomerNameCss;

const ScCustomerName = class {
    constructor(hostRef) {
        registerInstance(this, hostRef);
        this.scInput = createEvent(this, "scInput", 7);
        this.scFocus = createEvent(this, "scFocus", 7);
        this.scBlur = createEvent(this, "scBlur", 7);
        this.size = 'medium';
        this.value = null;
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
    /** Don't allow a blank space as an input here. */
    async reportValidity() {
        return this.input.reportValidity();
    }
    /** Silently update the checkout when the input changes. */
    async handleChange() {
        this.value = this.input.value;
        try {
            state.checkout = (await createOrUpdateCheckout({ id: state.checkout.id, data: { name: this.input.value } }));
        }
        catch (error) {
            console.error(error);
        }
    }
    /** Sync customer email with session if it's updated by other means */
    handleSessionChange() {
        var _a, _b, _c, _d, _e, _f;
        // we already have a value.
        if (this.value)
            return;
        const fromUrl = getValueFromUrl('full_name');
        if (!state$1.loggedIn && !!fromUrl) {
            this.value = fromUrl;
            return;
        }
        // we want the customer name to be forced if the user is logged in.
        if (state$1.loggedIn) {
            this.value = ((_b = (_a = state === null || state === void 0 ? void 0 : state.checkout) === null || _a === void 0 ? void 0 : _a.customer) === null || _b === void 0 ? void 0 : _b.name) || ((_c = state === null || state === void 0 ? void 0 : state.checkout) === null || _c === void 0 ? void 0 : _c.name);
            // otherwise we use the checkout name first.
        }
        else {
            this.value = ((_d = state === null || state === void 0 ? void 0 : state.checkout) === null || _d === void 0 ? void 0 : _d.name) || ((_f = (_e = state === null || state === void 0 ? void 0 : state.checkout) === null || _e === void 0 ? void 0 : _e.customer) === null || _f === void 0 ? void 0 : _f.name);
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
        return (h("sc-input", { key: '405c3f6ce8a692f29b4e85ac29bfdb9dba7d0f2e', type: "text", name: "name", ref: el => (this.input = el), value: this.value, label: this.label, help: this.help, autocomplete: "name", placeholder: this.placeholder, readonly: this.readonly, required: this.required, invalid: this.invalid, autofocus: this.autofocus, hasFocus: this.hasFocus, onScChange: () => this.handleChange(), onScInput: () => this.scInput.emit(), onScFocus: () => this.scFocus.emit(), onScBlur: () => this.scBlur.emit(), ...(this.disabled && { disabled: true }) }));
    }
};
ScCustomerName.style = ScCustomerNameStyle0;

export { ScCustomerName as sc_customer_name };

//# sourceMappingURL=sc-customer-name.entry.js.map