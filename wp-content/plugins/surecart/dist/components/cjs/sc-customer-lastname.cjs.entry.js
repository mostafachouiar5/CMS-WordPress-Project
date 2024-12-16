'use strict';

Object.defineProperty(exports, '__esModule', { value: true });

const index = require('./index-8acc3c89.js');
const store = require('./store-34d62f12.js');
const mutations = require('./mutations-19357660.js');
const util = require('./util-b877b2bd.js');
const index$1 = require('./index-771f480e.js');
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

const scCustomerLastnameCss = ":host{display:block}";
const ScCustomerLastnameStyle0 = scCustomerLastnameCss;

const ScCustomerLastname = class {
    constructor(hostRef) {
        index.registerInstance(this, hostRef);
        this.scInput = index.createEvent(this, "scInput", 7);
        this.scFocus = index.createEvent(this, "scFocus", 7);
        this.scBlur = index.createEvent(this, "scBlur", 7);
        this.loggedIn = undefined;
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
            mutations.state.checkout = (await index$1.createOrUpdateCheckout({ id: mutations.state.checkout.id, data: { last_name: this.input.value } }));
        }
        catch (error) {
            console.error(error);
        }
    }
    /** Sync customer last name with session if it's updated by other means */
    handleSessionChange() {
        var _a, _b, _c, _d, _e, _f;
        // we already have a value.
        if (this.value)
            return;
        const fromUrl = util.getValueFromUrl('last_name');
        if (!store.state.loggedIn && !!fromUrl) {
            this.value = fromUrl;
            return;
        }
        if (store.state.loggedIn) {
            this.value = ((_b = (_a = mutations.state === null || mutations.state === void 0 ? void 0 : mutations.state.checkout) === null || _a === void 0 ? void 0 : _a.customer) === null || _b === void 0 ? void 0 : _b.last_name) || ((_c = mutations.state === null || mutations.state === void 0 ? void 0 : mutations.state.checkout) === null || _c === void 0 ? void 0 : _c.last_name);
        }
        else {
            this.value = ((_d = mutations.state === null || mutations.state === void 0 ? void 0 : mutations.state.checkout) === null || _d === void 0 ? void 0 : _d.last_name) || ((_f = (_e = mutations.state === null || mutations.state === void 0 ? void 0 : mutations.state.checkout) === null || _e === void 0 ? void 0 : _e.customer) === null || _f === void 0 ? void 0 : _f.last_name);
        }
    }
    /** Listen to checkout. */
    componentWillLoad() {
        this.handleSessionChange();
        this.removeCheckoutListener = mutations.onChange('checkout', () => this.handleSessionChange());
    }
    /** Remove listener. */
    disconnectedCallback() {
        this.removeCheckoutListener();
    }
    render() {
        return (index.h("sc-input", { key: 'a823ba41f05201d19d051c703978c0c7fb245010', type: "text", name: "last_name", ref: el => (this.input = el), value: this.value, label: this.label, help: this.help, autocomplete: "last_name", placeholder: this.placeholder, readonly: this.readonly, required: this.required, invalid: this.invalid, autofocus: this.autofocus, hasFocus: this.hasFocus, onScChange: () => this.handleChange(), onScInput: () => this.scInput.emit(), onScFocus: () => this.scFocus.emit(), onScBlur: () => this.scBlur.emit(), ...(this.disabled && { disabled: true }) }));
    }
};
ScCustomerLastname.style = ScCustomerLastnameStyle0;

exports.sc_customer_lastname = ScCustomerLastname;

//# sourceMappingURL=sc-customer-lastname.cjs.entry.js.map