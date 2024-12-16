import { r as registerInstance, c as createEvent, h, a as getElement, H as Host, F as Fragment } from './index-745b6bec.js';
import { c as countryChoices, h as hasState } from './address-b892540d.js';
import { r as reportChildrenValidity, F as FormSubmitController } from './form-data-76641f16.js';
import { s as state, o as onChange, u as updateFormState } from './mutations-d5e8faea.js';
import { f as formBusy, a as formLoading } from './getters-929aa1df.js';
import { s as state$1 } from './store-7020541e.js';
import { o as openWormhole } from './consumer-e06b16d3.js';
import { l as lockCheckout, b as unLockCheckout, r as removeCheckoutLineItem, a as addCheckoutLineItem, t as trackOrderBump } from './mutations-01792dfb.js';
import { c as createOrUpdateCheckout } from './index-96490395.js';
import { s as speak } from './index-c5a96d53.js';
import { i as intervalString, g as getFormattedPrice } from './price-d5770168.js';
import { f as fullShippingAddressRequired, s as shippingAddressRequired, a as checkoutIsLocked } from './getters-e4172581.js';
import { c as createErrorNotice } from './mutations-ed6d0770.js';
import { i as isRtl } from './page-align-0cdacf32.js';
import './index-06061d4e.js';
import './utils-e9ee502a.js';
import './remove-query-args-938c53ea.js';
import './add-query-args-0e2a8393.js';
import './google-a86aa761.js';
import './currency-a0c9bff4.js';
import './fetch-2032d11d.js';

const scCompactAddressCss = ":host{display:block}.sc-address{display:block;position:relative}.sc-address [hidden]{display:none}.sc-address--loading{min-height:70px}.sc-address--loading sc-skeleton{display:block;margin-bottom:1em}.sc-address__control{display:block}.sc-address__control>*{margin-bottom:-1px}.sc-address__columns{display:flex;flex-direction:row;align-items:center;flex-wrap:wrap;justify-content:space-between}.sc-address__columns>*{flex:1;width:50%;margin-left:-1px}.sc-address__columns>*:first-child{margin-left:0}";
const ScCompactAddressStyle0 = scCompactAddressCss;

const ScCompactAddress = class {
    constructor(hostRef) {
        registerInstance(this, hostRef);
        this.scChangeAddress = createEvent(this, "scChangeAddress", 7);
        this.scInputAddress = createEvent(this, "scInputAddress", 7);
        this.address = {
            country: null,
            city: null,
            line_1: null,
            line_2: null,
            postal_code: null,
            state: null,
        };
        this.names = {
            country: 'shipping_country',
            city: 'shipping_city',
            line_1: 'shipping_line_1',
            line_2: 'shipping_line_2',
            postal_code: 'shipping_postal_code',
            state: 'shipping_state',
        };
        this.placeholders = {
            country: '',
            postal_code: '',
            state: '',
        };
        this.label = wp.i18n.__('Country or region', 'surecart');
        this.required = undefined;
        this.loading = undefined;
        this.countryChoices = countryChoices;
        this.regions = undefined;
        this.showState = undefined;
        this.showPostal = undefined;
    }
    /** When the state changes, we want to update city and postal fields. */
    handleAddressChange() {
        var _a;
        if (!((_a = this.address) === null || _a === void 0 ? void 0 : _a.country))
            return;
        this.setRegions();
        this.showState = ['US', 'CA'].includes(this.address.country);
        this.showPostal = ['US'].includes(this.address.country);
        this.scChangeAddress.emit(this.address);
        this.scInputAddress.emit(this.address);
    }
    updateAddress(address) {
        this.address = { ...this.address, ...address };
    }
    handleAddressInput(address) {
        this.scInputAddress.emit({ ...this.address, ...address });
    }
    clearAddress() {
        var _a;
        this.address = {
            name: (_a = this.address) === null || _a === void 0 ? void 0 : _a.name,
            country: null,
            line_1: null,
            line_2: null,
            city: null,
            postal_code: null,
            state: null,
        };
    }
    /** Set the regions based on the country. */
    setRegions() {
        if (hasState(this.address.country)) {
            import('./countries-c2f41f03.js').then(module => {
                this.regions = module === null || module === void 0 ? void 0 : module[this.address.country];
            });
        }
        else {
            this.regions = [];
        }
    }
    componentWillLoad() {
        var _a;
        this.handleAddressChange();
        const country = (_a = this.countryChoices.find(country => country.value === this.address.country)) === null || _a === void 0 ? void 0 : _a.value;
        if (country) {
            this.updateAddress({ country });
        }
    }
    async reportValidity() {
        return reportChildrenValidity(this.el);
    }
    getStatePlaceholder() {
        var _a, _b;
        if ((_a = this.placeholders) === null || _a === void 0 ? void 0 : _a.state)
            return this.placeholders.state;
        if (((_b = this.address) === null || _b === void 0 ? void 0 : _b.country) === 'US')
            return wp.i18n.__('State', 'surecart');
        return wp.i18n.__('Province/Region', 'surecart');
    }
    render() {
        var _a, _b, _c, _d, _e;
        return (h("div", { key: '0631a4d1b76f3a9c54d5d89cfe97e2595c8709a9', class: "sc-address", part: "base" }, h("sc-form-control", { key: '4dae490dd8df9620432e74be4abbd3c1ea8e0227', exportparts: "label, help-text, form-control", label: this.label, class: "sc-address__control", part: "control", required: this.required }, h("sc-select", { key: '0177da033ea57d127425742d409c2ad688b2a610', exportparts: "base:select__base, input, form-control, label, help-text, trigger, panel, caret, search__base, search__input, search__form-control, menu__base, spinner__base, empty", value: (_a = this.address) === null || _a === void 0 ? void 0 : _a.country, onScChange: (e) => {
                this.clearAddress();
                this.updateAddress({ country: e.target.value || null });
            }, choices: this.countryChoices, autocomplete: 'country-name', placeholder: ((_b = this.placeholders) === null || _b === void 0 ? void 0 : _b.country) || wp.i18n.__('Select Your Country', 'surecart'), name: this.names.country, search: true, unselect: false, "squared-bottom": this.showState || this.showPostal, required: this.required }), h("div", { key: '3739c449394bfab213c3b606c48d471cc3becd66', class: "sc-address__columns" }, this.showState && (h("sc-select", { key: '21843f066d2851e15333320cb191135dfcebef1e', exportparts: "base:select__base, input, form-control, label, help-text, trigger, panel, caret, search__base, search__input, search__form-control, menu__base, spinner__base, empty", placeholder: this.getStatePlaceholder(), name: this.names.state, autocomplete: 'address-level1', value: (_c = this === null || this === void 0 ? void 0 : this.address) === null || _c === void 0 ? void 0 : _c.state, onScChange: (e) => this.updateAddress({ state: e.target.value || null }), choices: this.regions, required: this.required, search: true, "squared-top": true, unselect: false, "squared-right": this.showPostal })), this.showPostal && (h("sc-input", { key: '35f39287a88109dc7cfe3d5f9962e58b9c4d1b37', exportparts: "base:input__base, input, form-control, label, help-text", placeholder: ((_d = this.placeholders) === null || _d === void 0 ? void 0 : _d.postal_code) || wp.i18n.__('Postal Code/Zip', 'surecart'), name: this.names.postal_code, onScChange: (e) => this.updateAddress({ postal_code: e.target.value || null }), onScInput: (e) => this.handleAddressInput({ name: e.target.value || null }), autocomplete: 'postal-code', required: this.required, value: (_e = this === null || this === void 0 ? void 0 : this.address) === null || _e === void 0 ? void 0 : _e.postal_code, "squared-top": true, maxlength: 5, "squared-left": this.showState })))), this.loading && h("sc-block-ui", { key: 'c85640a584a8bc3ef75640e5b25eaaf3a3a2b1bd', exportparts: "base:block-ui, content:block-ui__content" })));
    }
    get el() { return getElement(this); }
    static get watchers() { return {
        "address": ["handleAddressChange"]
    }; }
};
ScCompactAddress.style = ScCompactAddressStyle0;

const scInvoiceDetailsCss = ":host{display:block}::slotted(*){margin:4px 0 !important}::slotted(sc-divider){margin:16px 0 !important}";
const ScInvoiceDetailsStyle0 = scInvoiceDetailsCss;

const ScInvoiceDetails = class {
    constructor(hostRef) {
        registerInstance(this, hostRef);
    }
    render() {
        var _a;
        return (h(Host, { key: '829f6d656bf4afe04e3c90c6fbc7f26d3db6f2be', style: { ...(!((_a = state === null || state === void 0 ? void 0 : state.checkout) === null || _a === void 0 ? void 0 : _a.invoice) ? { display: 'none' } : {}) } }, h("div", { key: 'cb94d94d7317e603f03eca74cc6ce1fc66182d5d', class: "invoice-details" }, h("slot", { key: '08ea2b0d9a281f66b992f8def0f28e13818e35f0' }))));
    }
};
ScInvoiceDetails.style = ScInvoiceDetailsStyle0;

const scInvoiceMemoCss = ":host{display:block}.invoice-memo{font-size:var(--sc-font-size-small);line-height:var(--sc-line-height-dense);color:var(--sc-input-label-color);display:grid;gap:5px}.invoice-memo__content{text-align:left;color:var(--sc-input-help-text-color)}";
const ScInvoiceMemoStyle0 = scInvoiceMemoCss;

const ScLineItemInvoiceMemo = class {
    constructor(hostRef) {
        registerInstance(this, hostRef);
        this.text = undefined;
    }
    render() {
        var _a;
        const checkout = state === null || state === void 0 ? void 0 : state.checkout;
        const memo = ((_a = checkout === null || checkout === void 0 ? void 0 : checkout.invoice) === null || _a === void 0 ? void 0 : _a.memo) || null;
        // Stop if checkout has no invoice number.
        if (!memo) {
            return null;
        }
        // loading state
        if (formBusy() && !(checkout === null || checkout === void 0 ? void 0 : checkout.invoice)) {
            return (h("div", null, h("sc-skeleton", { style: { width: '100px' } }), h("sc-skeleton", { style: { width: '200px' } })));
        }
        return (h("div", { class: "invoice-memo" }, h("div", { class: "invoice-memo__title" }, this.text || wp.i18n.__('Memo', 'surecart')), h("div", { class: "invoice-memo__content" }, memo)));
    }
};
ScLineItemInvoiceMemo.style = ScInvoiceMemoStyle0;

const scLineItemInvoiceDueDateCss = ":host{display:block}sc-line-item{text-align:left;line-height:var(--sc-line-height-dense);color:var(--sc-input-label-color)}";
const ScLineItemInvoiceDueDateStyle0 = scLineItemInvoiceDueDateCss;

const ScLineItemInvoiceDueDate = class {
    constructor(hostRef) {
        registerInstance(this, hostRef);
    }
    render() {
        var _a;
        const checkout = state === null || state === void 0 ? void 0 : state.checkout;
        const dueDate = ((_a = checkout === null || checkout === void 0 ? void 0 : checkout.invoice) === null || _a === void 0 ? void 0 : _a.due_date) || null;
        // Stop if checkout has no invoice due date.
        if (!dueDate) {
            return null;
        }
        // loading state
        if (formBusy() && !(checkout === null || checkout === void 0 ? void 0 : checkout.invoice)) {
            return (h("sc-line-item", null, h("sc-skeleton", { slot: "title", style: { width: '120px', display: 'inline-block' } }), h("sc-skeleton", { slot: "price", style: { 'width': '50px', 'display': 'inline-block', '--border-radius': '6px' } })));
        }
        return (h("sc-line-item", null, h("span", { slot: "description" }, h("slot", { name: "title" }, wp.i18n.__('Due Date', 'surecart'))), h("sc-format-date", { slot: "price-description", date: dueDate, type: "timestamp", month: "short", day: "numeric", year: "numeric" })));
    }
};
ScLineItemInvoiceDueDate.style = ScLineItemInvoiceDueDateStyle0;

const scLineItemInvoiceNumberCss = ":host{display:block}sc-line-item{text-align:left;line-height:var(--sc-line-height-dense);color:var(--sc-input-label-color)}";
const ScLineItemInvoiceNumberStyle0 = scLineItemInvoiceNumberCss;

const ScLineItemInvoiceNumber = class {
    constructor(hostRef) {
        registerInstance(this, hostRef);
    }
    render() {
        var _a;
        const checkout = state === null || state === void 0 ? void 0 : state.checkout;
        const invoiceNumber = ((_a = checkout === null || checkout === void 0 ? void 0 : checkout.invoice) === null || _a === void 0 ? void 0 : _a.order_number) || null;
        // Stop if checkout has no invoice number.
        if (!invoiceNumber) {
            return null;
        }
        // loading state
        if (formBusy() && !(checkout === null || checkout === void 0 ? void 0 : checkout.invoice)) {
            return (h("sc-line-item", null, h("sc-skeleton", { slot: "title", style: { width: '120px', display: 'inline-block' } }), h("sc-skeleton", { slot: "price", style: { 'width': '50px', 'display': 'inline-block', '--border-radius': '6px' } })));
        }
        return (h("sc-line-item", null, h("span", { slot: "description" }, h("slot", { name: "title" }, wp.i18n.__('Invoice Number', 'surecart'))), h("span", { slot: "price-description" }, "#", invoiceNumber)));
    }
};
ScLineItemInvoiceNumber.style = ScLineItemInvoiceNumberStyle0;

const scLineItemInvoiceReceiptDownloadCss = ":host{display:block}sc-line-item{text-align:left;line-height:var(--sc-line-height-dense);color:var(--sc-input-label-color)}.sc-invoice-download-link{display:inline-flex;gap:var(--sc-spacing-x-small);text-decoration:none;color:inherit}";
const ScLineItemInvoiceReceiptDownloadStyle0 = scLineItemInvoiceReceiptDownloadCss;

const ScLineItemInvoiceReceiptDownload = class {
    constructor(hostRef) {
        registerInstance(this, hostRef);
        this.checkout = undefined;
    }
    render() {
        var _a;
        const checkout = state === null || state === void 0 ? void 0 : state.checkout;
        const receiptDownloadLink = ((_a = checkout === null || checkout === void 0 ? void 0 : checkout.invoice) === null || _a === void 0 ? void 0 : _a.id) ? checkout === null || checkout === void 0 ? void 0 : checkout.pdf_url : null;
        // Stop if checkout has no receipt download link.
        if (!receiptDownloadLink) {
            return null;
        }
        // loading state
        if (formBusy() && !(checkout === null || checkout === void 0 ? void 0 : checkout.invoice)) {
            return (h("sc-line-item", null, h("sc-skeleton", { slot: "title", style: { width: '120px', display: 'inline-block' } }), h("sc-skeleton", { slot: "price", style: { 'width': '50px', 'display': 'inline-block', '--border-radius': '6px' } })));
        }
        return (h("sc-line-item", null, h("span", { slot: "description" }, h("slot", { name: "title" }, wp.i18n.__('Receipt / Invoice', 'surecart'))), h("span", { slot: "price-description" }, h("a", { class: "sc-invoice-download-link", href: receiptDownloadLink, target: "_blank", rel: "noopener noreferrer" }, h("sc-icon", { name: "download" }), wp.i18n.__('Download', 'surecart')))));
    }
};
ScLineItemInvoiceReceiptDownload.style = ScLineItemInvoiceReceiptDownloadStyle0;

const scLineItemShippingCss = ":host{display:block}";
const ScLineItemShippingStyle0 = scLineItemShippingCss;

const ScLineItemShipping = class {
    constructor(hostRef) {
        registerInstance(this, hostRef);
        this.label = undefined;
    }
    render() {
        const { checkout } = state;
        // don't show if no shipping amount if no choice selected
        if (!(checkout === null || checkout === void 0 ? void 0 : checkout.selected_shipping_choice)) {
            return h(Host, { style: { display: 'none' } });
        }
        if (state$1.formState.value === 'loading') {
            return (h("sc-line-item", null, h("sc-skeleton", { slot: "title", style: { width: '120px', display: 'inline-block' } }), h("sc-skeleton", { slot: "price", style: { 'width': '70px', 'display': 'inline-block', '--border-radius': '6px' } })));
        }
        return (h("sc-line-item", null, h("span", { slot: "description" }, this.label || wp.i18n.__('Shipping', 'surecart')), h("span", { slot: "price" }, (checkout === null || checkout === void 0 ? void 0 : checkout.shipping_amount) ? (h("sc-format-number", { type: "currency", currency: checkout === null || checkout === void 0 ? void 0 : checkout.currency, value: checkout === null || checkout === void 0 ? void 0 : checkout.shipping_amount })) : (wp.i18n.__('Free', 'surecart')))));
    }
};
ScLineItemShipping.style = ScLineItemShippingStyle0;

const scLineItemTaxCss = ":host{display:block}";
const ScLineItemTaxStyle0 = scLineItemTaxCss;

const ScLineItemTax = class {
    constructor(hostRef) {
        registerInstance(this, hostRef);
        this.order = undefined;
        this.loading = undefined;
    }
    renderLabel() {
        var _a, _b, _c;
        let label = wp.i18n.sprintf(wp.i18n.__('Estimated %s', 'surecart'), ((_a = this === null || this === void 0 ? void 0 : this.order) === null || _a === void 0 ? void 0 : _a.tax_label) || '');
        if (((_b = this === null || this === void 0 ? void 0 : this.order) === null || _b === void 0 ? void 0 : _b.tax_status) === 'calculated') {
            label = ((_c = this.order) === null || _c === void 0 ? void 0 : _c.tax_label) || '';
        }
        return (h(Fragment, null, `${wp.i18n.__('Tax:', 'surecart')} ${label}`, this.renderPercent()));
    }
    renderPercent() {
        var _a;
        if ((_a = this.order) === null || _a === void 0 ? void 0 : _a.tax_percent) {
            return (h(Fragment, null, '(', this.order.tax_percent, "%", ')'));
        }
        return '';
    }
    render() {
        var _a, _b, _c, _d, _e, _f, _g;
        // hide if tax is 0
        if (!((_a = this === null || this === void 0 ? void 0 : this.order) === null || _a === void 0 ? void 0 : _a.tax_amount)) {
            return null;
        }
        return (h("sc-line-item", null, h("span", { slot: "description" }, this.renderLabel()), ((_b = this.order) === null || _b === void 0 ? void 0 : _b.tax_exclusive_amount) && (h("span", { slot: "price" }, h("sc-format-number", { type: "currency", currency: ((_c = this === null || this === void 0 ? void 0 : this.order) === null || _c === void 0 ? void 0 : _c.currency) || 'usd', value: (_d = this === null || this === void 0 ? void 0 : this.order) === null || _d === void 0 ? void 0 : _d.tax_exclusive_amount }))), ((_e = this.order) === null || _e === void 0 ? void 0 : _e.tax_inclusive_amount) && (h("span", { slot: "price-description" }, '(', h("sc-format-number", { type: "currency", currency: ((_f = this === null || this === void 0 ? void 0 : this.order) === null || _f === void 0 ? void 0 : _f.currency) || 'usd', value: (_g = this === null || this === void 0 ? void 0 : this.order) === null || _g === void 0 ? void 0 : _g.tax_inclusive_amount }), " ", wp.i18n.__('included', 'surecart'), ')'))));
    }
};
openWormhole(ScLineItemTax, ['order', 'loading'], false);
ScLineItemTax.style = ScLineItemTaxStyle0;

const scLineItemTrialCss = ":host{display:block}";
const ScLineItemTrialStyle0 = scLineItemTrialCss;

const ScLineItemTrial = class {
    constructor(hostRef) {
        registerInstance(this, hostRef);
        this.label = undefined;
    }
    render() {
        var _a;
        if (!((_a = state === null || state === void 0 ? void 0 : state.checkout) === null || _a === void 0 ? void 0 : _a.trial_amount)) {
            return h(Host, { style: { display: 'none' } });
        }
        return (h("sc-line-item", null, h("span", { slot: "description" }, this.label || wp.i18n.__('Trial', 'surecart')), h("sc-format-number", { slot: "price", type: "currency", currency: state.checkout.currency, value: state.checkout.trial_amount })));
    }
};
ScLineItemTrial.style = ScLineItemTrialStyle0;

const scOrderBillingAddressCss = ":host{display:block}.order-billing-address__toggle{margin-bottom:var(--sc-form-row-spacing, var(--sc-spacing-medium))}";
const ScOrderBillingAddressStyle0 = scOrderBillingAddressCss;

const ScOrderBillingAddress = class {
    constructor(hostRef) {
        registerInstance(this, hostRef);
        this.label = undefined;
        this.showName = undefined;
        this.namePlaceholder = wp.i18n.__('Name or Company Name', 'surecart');
        this.countryPlaceholder = wp.i18n.__('Country', 'surecart');
        this.cityPlaceholder = wp.i18n.__('City', 'surecart');
        this.line1Placeholder = wp.i18n.__('Address', 'surecart');
        this.line2Placeholder = wp.i18n.__('Address Line 2', 'surecart');
        this.postalCodePlaceholder = wp.i18n.__('Postal Code/Zip', 'surecart');
        this.statePlaceholder = wp.i18n.__('State/Province/Region', 'surecart');
        this.defaultCountry = undefined;
        this.toggleLabel = wp.i18n.__('Billing address is same as shipping', 'surecart');
        this.address = {
            country: null,
            city: null,
            line_1: null,
            line_2: null,
            postal_code: null,
            state: null,
        };
    }
    async reportValidity() {
        var _a, _b;
        if (!this.input)
            return true;
        return (_b = (_a = this.input) === null || _a === void 0 ? void 0 : _a.reportValidity) === null || _b === void 0 ? void 0 : _b.call(_a);
    }
    prefillAddress() {
        var _a;
        // check if address keys are empty, if so, update them.
        const addressKeys = Object.keys(this.address).filter(key => key !== 'country');
        const emptyAddressKeys = addressKeys.filter(key => !this.address[key]);
        if (emptyAddressKeys.length === addressKeys.length) {
            this.address = { ...this.address, ...(_a = state.checkout) === null || _a === void 0 ? void 0 : _a.billing_address };
        }
    }
    componentWillLoad() {
        var _a;
        if (this.defaultCountry && !((_a = this.address) === null || _a === void 0 ? void 0 : _a.country)) {
            this.address.country = this.defaultCountry;
        }
        this.prefillAddress();
        onChange('checkout', () => this.prefillAddress());
    }
    async updateAddressState(address) {
        var _a, _b;
        if (JSON.stringify(address) === JSON.stringify(this.address))
            return; // no change, don't update.
        this.address = address;
        try {
            lockCheckout('billing-address');
            state.checkout = (await createOrUpdateCheckout({
                id: (_a = state === null || state === void 0 ? void 0 : state.checkout) === null || _a === void 0 ? void 0 : _a.id,
                data: {
                    billing_matches_shipping: (_b = state.checkout) === null || _b === void 0 ? void 0 : _b.billing_matches_shipping,
                    billing_address: this.address,
                },
            }));
        }
        catch (e) {
            console.error(e);
        }
        finally {
            unLockCheckout('billing-address');
        }
    }
    async onToggleBillingMatchesShipping(e) {
        state.checkout = {
            ...state.checkout,
            billing_matches_shipping: e.target.checked,
        };
    }
    shippingAddressFieldExists() {
        return !!document.querySelector('sc-order-shipping-address');
    }
    render() {
        var _a, _b;
        return (h(Fragment, { key: '77e7bb05d506d9d884773382b8dc3a6416eecd47' }, this.shippingAddressFieldExists() && (h("sc-checkbox", { key: 'd01d4908f3ab9495b9dfb463a6a0578373f7a439', class: "order-billing-address__toggle", onScChange: e => this.onToggleBillingMatchesShipping(e), checked: (_a = state.checkout) === null || _a === void 0 ? void 0 : _a.billing_matches_shipping }, this.toggleLabel)), (!this.shippingAddressFieldExists() || !((_b = state.checkout) === null || _b === void 0 ? void 0 : _b.billing_matches_shipping)) && (h("sc-address", { key: '5aa8eef12cab2285fae0fdda5da49b64657b7de6', exportparts: "label, help-text, form-control, input__base, select__base, columns, search__base, menu__base", ref: el => {
                this.input = el;
            }, label: this.label || wp.i18n.__('Billing Address', 'surecart'), placeholders: {
                name: this.namePlaceholder,
                country: this.countryPlaceholder,
                city: this.cityPlaceholder,
                line_1: this.line1Placeholder,
                line_2: this.line2Placeholder,
                postal_code: this.postalCodePlaceholder,
                state: this.statePlaceholder,
            }, names: {
                name: 'billing_name',
                country: 'billing_country',
                city: 'billing_city',
                line_1: 'billing_line_1',
                line_2: 'billing_line_2',
                postal_code: 'billing_postal_code',
                state: 'billing_state',
            }, required: true, loading: formLoading(), address: this.address, "show-name": this.showName, onScChangeAddress: e => this.updateAddressState(e.detail) }))));
    }
};
ScOrderBillingAddress.style = ScOrderBillingAddressStyle0;

const scOrderBumpCss = ":host {\n  display: block;\n}\n\n.bump {\n  display: grid;\n  gap: 1em;\n}\n.bump__text {\n  display: grid;\n  gap: 0.25em;\n}\n.bump__tag {\n  background: var(--sc-color-primary-500);\n  color: var(--sc-color-white);\n  border-radius: var(--sc-input-border-radius-medium);\n  padding: var(--sc-spacing-x-small);\n  font-size: var(--sc-font-size-x-small);\n}\n.bump__product {\n  display: flex;\n  align-items: center;\n  gap: var(--sc-choice-padding, 1.3em 1.1em);\n  line-height: var(--sc-line-height-dense);\n}\n.bump__product--wrapper {\n  container-type: inline-size;\n}\n@container (max-width: 325px) {\n  .bump__product {\n    flex-direction: column;\n    align-items: start;\n  }\n}\n.bump__product-title {\n  font-weight: var(--sc-font-weight-semibold);\n}\n.bump__product-description {\n  color: var(--sc-input-label-color);\n}\n.bump__image {\n  width: var(--sc-product-line-item-image-size, 4em);\n  height: var(--sc-product-line-item-image-size, 4em);\n  flex: 0 0 var(--sc-product-line-item-image-size, 4em);\n  object-fit: cover;\n  border-radius: 4px;\n  border: 1px solid var(--sc-color-gray-200);\n  display: block;\n  box-shadow: var(--sc-input-box-shadow);\n}\n.bump__price--has-discount .bump__original-price {\n  text-decoration: line-through;\n  color: var(--sc-color-gray-500);\n  font-size: var(--sc-font-size-small);\n}\n.bump__price .bump__new-price {\n  font-size: var(--sc-font-size-large);\n  color: var(--sc-color-gray-700);\n}\n.bump__price .bump__interval {\n  color: var(--sc-color-gray-500);\n}\n.bump__amount {\n  display: flex;\n  align-items: center;\n  gap: var(--sc-spacing-x-small);\n  flex-wrap: wrap;\n  margin-top: var(--sc-spacing-xx-small);\n}";
const ScOrderBumpStyle0 = scOrderBumpCss;

const ScOrderBump = class {
    constructor(hostRef) {
        registerInstance(this, hostRef);
        this.bump = undefined;
        this.showControl = undefined;
    }
    /** The bump line item */
    lineItem() {
        var _a, _b, _c;
        return (_c = (_b = (_a = state === null || state === void 0 ? void 0 : state.checkout) === null || _a === void 0 ? void 0 : _a.line_items) === null || _b === void 0 ? void 0 : _b.data) === null || _c === void 0 ? void 0 : _c.find(item => { var _a; return (item === null || item === void 0 ? void 0 : item.bump) === ((_a = this.bump) === null || _a === void 0 ? void 0 : _a.id); });
    }
    /** Update the line item. */
    updateLineItem() {
        var _a, _b, _c, _d;
        const price = ((_a = this.bump.price) === null || _a === void 0 ? void 0 : _a.id) || ((_b = this.bump) === null || _b === void 0 ? void 0 : _b.price);
        if (this.lineItem()) {
            removeCheckoutLineItem((_c = this.lineItem()) === null || _c === void 0 ? void 0 : _c.id);
            speak(wp.i18n.__('Order bump Removed.', 'surecart'));
            return;
        }
        addCheckoutLineItem({
            bump: (_d = this.bump) === null || _d === void 0 ? void 0 : _d.id,
            price,
            quantity: 1,
        });
        speak(wp.i18n.__('Order bump applied.', 'surecart'));
    }
    componentDidLoad() {
        var _a;
        trackOrderBump((_a = this.bump) === null || _a === void 0 ? void 0 : _a.id);
    }
    newPrice() {
        var _a, _b, _c, _d, _e, _f;
        let amount = null;
        let initialAmount = ((_b = (_a = this.bump) === null || _a === void 0 ? void 0 : _a.price) === null || _b === void 0 ? void 0 : _b.amount) || 0;
        if ((_c = this.bump) === null || _c === void 0 ? void 0 : _c.amount_off) {
            amount = Math.max(0, initialAmount - ((_d = this.bump) === null || _d === void 0 ? void 0 : _d.amount_off));
        }
        if ((_e = this.bump) === null || _e === void 0 ? void 0 : _e.percent_off) {
            const off = initialAmount * (((_f = this.bump) === null || _f === void 0 ? void 0 : _f.percent_off) / 100);
            amount = Math.max(0, initialAmount - off);
        }
        return amount;
    }
    renderInterval() {
        var _a;
        const interval = intervalString((_a = this.bump) === null || _a === void 0 ? void 0 : _a.price, { labels: { interval: '/', period: wp.i18n.__('for', 'surecart') } });
        if (!interval.trim().length)
            return null;
        return h("span", { class: "bump__interval" }, interval);
    }
    renderPrice() {
        var _a, _b, _c, _d, _e, _f, _g, _h, _j, _k, _l;
        return (h("div", { slot: "description", class: { 'bump__price': true, 'bump__price--has-discount': !!((_a = this.bump) === null || _a === void 0 ? void 0 : _a.percent_off) || !!((_b = this.bump) === null || _b === void 0 ? void 0 : _b.amount_off) }, part: "price" }, h("span", { "aria-label": 
            /** translators: %s: old price */
            wp.i18n.sprintf(wp.i18n.__('Originally priced at %s.', 'surecart'), getFormattedPrice({
                amount: (_d = (_c = this.bump) === null || _c === void 0 ? void 0 : _c.price) === null || _d === void 0 ? void 0 : _d.amount,
                currency: (_f = (_e = this.bump) === null || _e === void 0 ? void 0 : _e.price) === null || _f === void 0 ? void 0 : _f.currency,
            })) }, h("sc-format-number", { type: "currency", class: "bump__original-price", value: (_h = (_g = this.bump) === null || _g === void 0 ? void 0 : _g.price) === null || _h === void 0 ? void 0 : _h.amount, currency: (_k = (_j = this.bump) === null || _j === void 0 ? void 0 : _j.price) === null || _k === void 0 ? void 0 : _k.currency }), ' '), h("span", null, h("span", { "aria-hidden": "true" }, this.newPrice() === 0 && wp.i18n.__('Free', 'surecart'), this.newPrice() !== null && this.newPrice() > 0 && (h("sc-format-number", { type: "currency", class: "bump__new-price", value: this.newPrice(), currency: ((_l = this.bump) === null || _l === void 0 ? void 0 : _l.price).currency })), this.renderInterval()))));
    }
    renderDiscount() {
        var _a, _b, _c, _d, _e, _f, _g, _h;
        if (!!((_a = this.bump) === null || _a === void 0 ? void 0 : _a.amount_off)) {
            return (h("div", { class: "bump__tag", "aria-label": 
                /** translators: %1$s: amount off, %2$s: currency */
                wp.i18n.sprintf(wp.i18n.__('You save %1$s%2$s.', 'surecart'), (_b = this.bump) === null || _b === void 0 ? void 0 : _b.amount_off, ((_c = this.bump) === null || _c === void 0 ? void 0 : _c.price).currency) }, h("span", { "aria-hidden": "true" }, wp.i18n.__('Save', 'surecart'), " ", h("sc-format-number", { type: "currency", value: (_d = this.bump) === null || _d === void 0 ? void 0 : _d.amount_off, currency: ((_e = this.bump) === null || _e === void 0 ? void 0 : _e.price).currency }))));
        }
        if (!!((_f = this.bump) === null || _f === void 0 ? void 0 : _f.percent_off)) {
            return (h("div", { class: "bump__tag", "aria-label": 
                /** translators: %s: amount percent off */
                wp.i18n.sprintf(wp.i18n.__('You save %s%%.', 'surecart'), (_g = this.bump) === null || _g === void 0 ? void 0 : _g.percent_off) }, h("span", { "aria-hidden": "true" }, wp.i18n.sprintf(wp.i18n.__('Save %s%%', 'surecart'), (_h = this.bump) === null || _h === void 0 ? void 0 : _h.percent_off))));
        }
    }
    render() {
        var _a, _b, _c, _d, _e, _f, _g, _h, _j, _k, _l, _m, _o, _p, _q, _r, _s, _t, _u, _v;
        const product = (_b = (_a = this.bump) === null || _a === void 0 ? void 0 : _a.price) === null || _b === void 0 ? void 0 : _b.product;
        return (h("sc-choice", { key: '09fa27b1aab98270ba14b7f48d4c2ee1644f265c', value: (_c = this.bump) === null || _c === void 0 ? void 0 : _c.id, type: "checkbox", showControl: this.showControl, checked: !!this.lineItem(), onClick: e => {
                e.preventDefault();
                e.stopImmediatePropagation();
                this.updateLineItem();
            }, onKeyDown: e => {
                if (e.key === 'Enter' || e.key === ' ') {
                    e.preventDefault();
                    e.stopImmediatePropagation();
                    this.updateLineItem();
                }
            }, exportparts: "base, control, checked-icon, title" }, h("div", { key: '8047e3928e73deec669c1347a2e49af9067a4a1d', part: "base-content", class: "bump" }, h("div", { key: 'ff614b3aaee8ba7724c6f47b7648108936295a20', class: "bump__text" }, h("div", { key: '431ac167738bc65aad22c1eb7b6d523e9124c07a', class: "bump__title", "aria-label": wp.i18n.sprintf(
            /* translators: %s: order bump name */
            wp.i18n.__('Product: %s.', 'surecart'), ((_e = (_d = this.bump) === null || _d === void 0 ? void 0 : _d.metadata) === null || _e === void 0 ? void 0 : _e.cta) || ((_f = this.bump) === null || _f === void 0 ? void 0 : _f.name) || (product === null || product === void 0 ? void 0 : product.name)) }, h("span", { key: 'c87fb8019d9407fd4b9660d352efbe3c494b98b8', "aria-hidden": "true" }, ((_h = (_g = this.bump) === null || _g === void 0 ? void 0 : _g.metadata) === null || _h === void 0 ? void 0 : _h.cta) || ((_j = this.bump) === null || _j === void 0 ? void 0 : _j.name) || (product === null || product === void 0 ? void 0 : product.name))), h("div", { key: 'f03777d631f61529066f9691f3b260dd662f54c8', class: "bump__amount" }, h("span", { key: '43eff2d5f826ac631f40325f58b274829d1aa999' }, this.renderPrice()), h("span", { key: 'd7f0127c0614ca9f84ff3aa62df496d3fd28820c' }, this.renderDiscount())))), ((_l = (_k = this.bump) === null || _k === void 0 ? void 0 : _k.metadata) === null || _l === void 0 ? void 0 : _l.description) && (h("div", { key: 'e0807606c9be9d308afe7d2aec2a721f5a1d2c39', slot: "footer", class: "bump__product--wrapper" }, h("sc-divider", { key: '88942eb9b2fa66b2453c52cc842c5a70d13eaec2', style: { '--spacing': 'var(--sc-spacing-medium)' } }), h("div", { key: '2919eebff004cb8ef4aab94f088b6f6259454625', class: "bump__product" }, !!((_m = product === null || product === void 0 ? void 0 : product.line_item_image) === null || _m === void 0 ? void 0 : _m.src) && h("img", { key: '10ace4ec5c232e753d69c3914b3638940f613a97', ...product === null || product === void 0 ? void 0 : product.line_item_image, class: "bump__image" }), h("div", { key: '8213fe8efc0677b4d0937a6d2e8df7ebf29b039f', class: "bump__product-text" }, !!((_p = (_o = this.bump) === null || _o === void 0 ? void 0 : _o.metadata) === null || _p === void 0 ? void 0 : _p.cta) && (h("div", { key: 'd7876e8617872279ed01467e4995674d85f92021', class: "bump__product-title", "aria-hidden": "true" }, this.bump.name || (product === null || product === void 0 ? void 0 : product.name))), !!((_r = (_q = this.bump) === null || _q === void 0 ? void 0 : _q.metadata) === null || _r === void 0 ? void 0 : _r.description) && (h("div", { key: '8b93ba126f03d8f71498ecb2f8119d77ec99dbfc', class: "bump__product-description", "aria-label": wp.i18n.sprintf(
            /* translators: %s: Product description */
            wp.i18n.__('Product description: %s.', 'surecart'), (_t = (_s = this.bump) === null || _s === void 0 ? void 0 : _s.metadata) === null || _t === void 0 ? void 0 : _t.description) }, h("span", { key: 'c51ceb978a388423adc3c0927fd1a91aa7d25547', "aria-hidden": "true" }, (_v = (_u = this.bump) === null || _u === void 0 ? void 0 : _u.metadata) === null || _v === void 0 ? void 0 : _v.description)))))))));
    }
};
ScOrderBump.style = ScOrderBumpStyle0;

const scOrderBumpsCss = ":host{display:block}.bumps__list{display:grid;gap:10px}";
const ScOrderBumpsStyle0 = scOrderBumpsCss;

const ScOrderBumps = class {
    constructor(hostRef) {
        registerInstance(this, hostRef);
        this.label = undefined;
        this.showControl = undefined;
        this.help = undefined;
    }
    render() {
        var _a, _b;
        const bumps = (((_b = (_a = state === null || state === void 0 ? void 0 : state.checkout) === null || _a === void 0 ? void 0 : _a.recommended_bumps) === null || _b === void 0 ? void 0 : _b.data) || []).filter(bump => { var _a, _b, _c, _d; return ((_d = (_c = (_b = (_a = bump === null || bump === void 0 ? void 0 : bump.price) === null || _a === void 0 ? void 0 : _a.product) === null || _b === void 0 ? void 0 : _b.variants) === null || _c === void 0 ? void 0 : _c.pagination) === null || _d === void 0 ? void 0 : _d.count) === 0; }); // exclude variants for now.;
        if (!(bumps === null || bumps === void 0 ? void 0 : bumps.length)) {
            return null;
        }
        return (h("sc-form-control", { label: this.label || wp.i18n.__('Recommended', 'surecart'), help: this.help }, h("div", { class: "bumps__list", "aria-label": wp.i18n.__('Order bump summary', 'surecart') }, bumps.map(bump => (h("sc-order-bump", { key: bump === null || bump === void 0 ? void 0 : bump.id, showControl: this.showControl, bump: bump }))))));
    }
};
ScOrderBumps.style = ScOrderBumpsStyle0;

const scOrderShippingAddressCss = ":host{display:block}.sc-order-shipping__loading{display:flex;flex-direction:column;gap:0.5em}";
const ScOrderShippingAddressStyle0 = scOrderShippingAddressCss;

const ScOrderShippingAddress = class {
    constructor(hostRef) {
        registerInstance(this, hostRef);
        /** Names for the address */
        this.names = {
            name: 'shipping_name',
            country: 'shipping_country',
            city: 'shipping_city',
            line_1: 'shipping_line_1',
            line_2: 'shipping_line_2',
            postal_code: 'shipping_postal_code',
            state: 'shipping_state',
        };
        this.label = undefined;
        this.required = false;
        this.full = undefined;
        this.showName = undefined;
        this.namePlaceholder = wp.i18n.__('Name or Company Name', 'surecart');
        this.countryPlaceholder = wp.i18n.__('Country', 'surecart');
        this.cityPlaceholder = wp.i18n.__('City', 'surecart');
        this.line1Placeholder = wp.i18n.__('Address', 'surecart');
        this.line2Placeholder = wp.i18n.__('Address Line 2', 'surecart');
        this.postalCodePlaceholder = wp.i18n.__('Postal Code/Zip', 'surecart');
        this.statePlaceholder = wp.i18n.__('State/Province/Region', 'surecart');
        this.defaultCountry = undefined;
        this.requireName = false;
        this.placeholders = {
            name: wp.i18n.__('Name or Company Name', 'surecart'),
            country: wp.i18n.__('Country', 'surecart'),
            city: wp.i18n.__('City', 'surecart'),
            line_1: wp.i18n.__('Address', 'surecart'),
            line_2: wp.i18n.__('Address Line 2', 'surecart'),
            postal_code: wp.i18n.__('Postal Code/Zip', 'surecart'),
            state: wp.i18n.__('State/Province/Region', 'surecart'),
        };
        this.address = {
            country: null,
            city: null,
            line_1: null,
            line_2: null,
            postal_code: null,
            state: null,
        };
    }
    async updateAddressState(address) {
        var _a;
        if (JSON.stringify(address) === JSON.stringify(this.address))
            return; // no change, don't update.
        this.address = address;
        try {
            lockCheckout('shipping-address');
            state.checkout = (await createOrUpdateCheckout({
                id: (_a = state.checkout) === null || _a === void 0 ? void 0 : _a.id,
                data: {
                    shipping_address: this.address,
                },
            }));
        }
        catch (e) {
            console.error(e);
        }
        finally {
            unLockCheckout('shipping-address');
        }
    }
    async reportValidity() {
        var _a, _b;
        if (!this.input)
            return true;
        return (_b = (_a = this.input) === null || _a === void 0 ? void 0 : _a.reportValidity) === null || _b === void 0 ? void 0 : _b.call(_a);
    }
    prefillAddress() {
        var _a;
        // check if address keys are empty, if so, update them.
        const addressKeys = Object.keys(this.address).filter(key => key !== 'country');
        const emptyAddressKeys = addressKeys.filter(key => !this.address[key]);
        if (emptyAddressKeys.length === addressKeys.length) {
            this.address = { ...this.address, ...(_a = state.checkout) === null || _a === void 0 ? void 0 : _a.shipping_address };
        }
    }
    componentWillLoad() {
        var _a;
        if (this.defaultCountry && !((_a = this.address) === null || _a === void 0 ? void 0 : _a.country)) {
            this.address.country = this.defaultCountry;
        }
        this.prefillAddress();
        onChange('checkout', () => this.prefillAddress());
    }
    render() {
        // use full if checkout requires it, it's set, or we're showing/requiring name field.
        if (fullShippingAddressRequired() || this.full || this.requireName || this.showName) {
            return (h("sc-address", { exportparts: "label, help-text, form-control, input__base, select__base, columns, search__base, menu__base", ref: el => (this.input = el), label: this.label || wp.i18n.__('Shipping Address', 'surecart'), placeholders: {
                    name: this.namePlaceholder,
                    country: this.countryPlaceholder,
                    city: this.cityPlaceholder,
                    line_1: this.line1Placeholder,
                    line_2: this.line2Placeholder,
                    postal_code: this.postalCodePlaceholder,
                    state: this.statePlaceholder,
                }, names: this.names, required: this.required || shippingAddressRequired(), loading: formLoading(), address: this.address, "show-name": this.showName, "require-name": this.requireName, onScChangeAddress: e => this.updateAddressState(e.detail) }));
        }
        return (h("sc-compact-address", { ref: el => (this.input = el), required: this.required || shippingAddressRequired(), loading: formLoading(), address: this.address, placeholders: {
                name: this.namePlaceholder,
                country: this.countryPlaceholder,
                city: this.cityPlaceholder,
                line_1: this.line1Placeholder,
                line_2: this.line2Placeholder,
                postal_code: this.postalCodePlaceholder,
                state: this.statePlaceholder,
            }, names: this.names, label: this.label, onScChangeAddress: e => this.updateAddressState(e.detail) }));
    }
};
ScOrderShippingAddress.style = ScOrderShippingAddressStyle0;

const scOrderTaxIdInputCss = ":host{display:block}";
const ScOrderTaxIdInputStyle0 = scOrderTaxIdInputCss;

const ScOrderTaxIdInput = class {
    constructor(hostRef) {
        registerInstance(this, hostRef);
        this.show = false;
        this.otherLabel = undefined;
        this.caGstLabel = undefined;
        this.auAbnLabel = undefined;
        this.gbVatLabel = undefined;
        this.euVatLabel = undefined;
        this.helpText = undefined;
        this.taxIdTypes = undefined;
        this.taxIdTypesData = [];
    }
    handleTaxIdTypesChange() {
        this.taxIdTypesData = typeof this.taxIdTypes === 'string' ? JSON.parse(this.taxIdTypes) : this.taxIdTypes;
    }
    async reportValidity() {
        return this.input.reportValidity();
    }
    getStatus() {
        var _a, _b, _c, _d, _e;
        if (((_b = (_a = state.checkout) === null || _a === void 0 ? void 0 : _a.tax_identifier) === null || _b === void 0 ? void 0 : _b.number_type) !== 'eu_vat') {
            return 'unknown';
        }
        if (((_c = state.taxProtocol) === null || _c === void 0 ? void 0 : _c.eu_vat_unverified_behavior) === 'apply_reverse_charge') {
            return 'unknown';
        }
        return ((_e = (_d = state.checkout) === null || _d === void 0 ? void 0 : _d.tax_identifier) === null || _e === void 0 ? void 0 : _e.eu_vat_verified) ? 'valid' : 'invalid';
    }
    async updateOrder(tax_identifier) {
        try {
            updateFormState('FETCH');
            state.checkout = (await createOrUpdateCheckout({
                id: state.checkout.id,
                data: { tax_identifier },
            }));
            updateFormState('RESOLVE');
        }
        catch (e) {
            console.error(e);
            createErrorNotice(e);
            updateFormState('REJECT');
        }
    }
    componentWillLoad() {
        this.handleTaxIdTypesChange();
    }
    required() {
        var _a, _b, _c;
        return ((_a = state.taxProtocol) === null || _a === void 0 ? void 0 : _a.eu_vat_required) && ((_c = (_b = state.checkout) === null || _b === void 0 ? void 0 : _b.tax_identifier) === null || _c === void 0 ? void 0 : _c.number_type) === 'eu_vat';
    }
    render() {
        var _a, _b, _c, _d, _e, _f, _g;
        return (h("sc-tax-id-input", { key: '1b9da696ae1c015317ec9f9075035811291d936d', ref: el => (this.input = el), show: this.show, number: (_b = (_a = state.checkout) === null || _a === void 0 ? void 0 : _a.tax_identifier) === null || _b === void 0 ? void 0 : _b.number, type: ((_d = (_c = state.checkout) === null || _c === void 0 ? void 0 : _c.tax_identifier) === null || _d === void 0 ? void 0 : _d.number_type) || ((_e = this.taxIdTypesData) === null || _e === void 0 ? void 0 : _e[0]) || 'eu_vat', country: (_g = (_f = state.checkout) === null || _f === void 0 ? void 0 : _f.shipping_address) === null || _g === void 0 ? void 0 : _g.country, status: this.getStatus(), loading: formBusy(), onScChange: e => {
                e.stopImmediatePropagation();
                this.updateOrder(e.detail);
            }, otherLabel: this.otherLabel, caGstLabel: this.caGstLabel, auAbnLabel: this.auAbnLabel, gbVatLabel: this.gbVatLabel, euVatLabel: this.euVatLabel, help: this.helpText, taxIdTypes: this.taxIdTypesData, required: this.required() }));
    }
    static get watchers() { return {
        "taxIdTypes": ["handleTaxIdTypesChange"]
    }; }
};
ScOrderTaxIdInput.style = ScOrderTaxIdInputStyle0;

const scRadioCss = ":host{display:inline-block}::slotted([slot=description]){display:block;color:var(--sc-radio-description-color, var(--sc-input-help-text-color, var(--sc-color-gray-500)));line-height:var(--sc-line-height-dense);margin:0.5em 0 0;font-size:var(--sc-font-size-small)}.radio{display:inline-flex;align-items:flex-start;font-family:var(--sc-input-font-family);font-size:var(--sc-input-font-size-medium);font-weight:var(--sc-input-font-weight);color:var(--sc-input-color);vertical-align:middle;gap:var(--sc-spacing-xx-small)}.radio:not(.radio--editing){cursor:pointer}.radio__icon{display:inline-flex;width:var(--sc-radio-size);height:var(--sc-radio-size)}.radio__icon svg{width:100%;height:100%}.radio__control{flex:0 0 auto;position:relative;display:inline-flex;align-items:center;justify-content:center;width:var(--sc-radio-size);height:var(--sc-radio-size);border:solid var(--sc-input-border-width) var(--sc-input-border-color);border-radius:50%;background-color:var(--sc-input-background-color);color:transparent;transition:var(--sc-input-transition, var(--sc-transition-medium)) border-color, var(--sc-input-transition, var(--sc-transition-medium)) opacity, var(--sc-input-transition, var(--sc-transition-medium)) background-color, var(--sc-input-transition, var(--sc-transition-medium)) color, var(--sc-input-transition, var(--sc-transition-medium)) box-shadow}.radio__control input[type=radio]{position:absolute;opacity:0;padding:0;margin:0;pointer-events:none}.radio:not(.radio--checked):not(.radio--disabled) .radio__control:hover{border-color:var(--sc-input-border-color-hover);background-color:var(--sc-input-background-color-hover)}.radio.radio--focused:not(.radio--checked):not(.radio--disabled) .radio__control{border-color:var(--sc-input-border-color-focus);background-color:var(--sc-input-background-color-focus);box-shadow:0 0 0 var(--sc-focus-ring-width) var(--sc-focus-ring-color-primary)}.radio--checked .radio__control{color:var(--var-sc-checked-radio-background-color, var(--sc-input-background-color));border-color:var(--sc-color-primary-500);background-color:var(--sc-color-primary-500)}.radio.radio--checked:not(.radio--disabled) .radio__control:hover{opacity:0.8}.radio.radio--checked:not(.radio--disabled).radio--focused .radio__control{border-color:var(--var-sc-checked-radio-border-color, var(--sc-input-background-color));background-color:var(--sc-color-primary-500);box-shadow:0 0 0 var(--sc-focus-ring-width) var(--sc-focus-ring-color-primary)}.radio--disabled{opacity:0.5;cursor:not-allowed}.radio:not(.radio--checked) svg circle{opacity:0}.radio__label{line-height:var(--sc-radio-size);margin-left:0.5em;user-select:none}";
const ScRadioStyle0 = scRadioCss;

let id = 0;
const ScRadio = class {
    constructor(hostRef) {
        registerInstance(this, hostRef);
        this.scBlur = createEvent(this, "scBlur", 7);
        this.scChange = createEvent(this, "scChange", 7);
        this.scFocus = createEvent(this, "scFocus", 7);
        this.inputId = `radio-${++id}`;
        this.labelId = `radio-label-${id}`;
        this.hasFocus = false;
        this.name = undefined;
        this.value = undefined;
        this.disabled = false;
        this.checked = false;
        this.required = false;
        this.invalid = false;
        this.edit = undefined;
    }
    /** Simulates a click on the radio. */
    async ceClick() {
        this.input.click();
    }
    /** Checks for validity and shows the browser's validation message if the control is invalid. */
    async reportValidity() {
        this.invalid = !this.input.checkValidity();
        return this.input.reportValidity();
    }
    handleCheckedChange() {
        if (!this.input)
            return;
        if (this.checked) {
            this.getSiblingRadios().map(radio => (radio.checked = false));
        }
        this.input.checked = this.checked;
        this.scChange.emit();
    }
    handleClick() {
        this.checked = true;
    }
    handleBlur() {
        this.hasFocus = false;
        this.scBlur.emit();
    }
    handleFocus() {
        this.hasFocus = true;
        this.scFocus.emit();
    }
    /** Sets a custom validation message. If `message` is not empty, the field will be considered invalid. */
    setCustomValidity(message) {
        this.input.setCustomValidity(message);
        this.invalid = !this.input.checkValidity();
    }
    getAllRadios() {
        const radioGroup = this.el.closest('sc-radio-group');
        // Radios must be part of a radio group
        if (!radioGroup) {
            return [];
        }
        return [...radioGroup.querySelectorAll('sc-radio')];
    }
    getSiblingRadios() {
        return this.getAllRadios().filter(radio => radio !== this.el);
    }
    handleKeyDown(event) {
        if (this.edit)
            return true;
        if (['ArrowUp', 'ArrowDown', 'ArrowLeft', 'ArrowRight'].includes(event.key)) {
            const radios = this.getAllRadios().filter(radio => !radio.disabled);
            const incr = ['ArrowUp', 'ArrowLeft'].includes(event.key) ? -1 : 1;
            let index = radios.indexOf(this.el) + incr;
            if (index < 0)
                index = radios.length - 1;
            if (index > radios.length - 1)
                index = 0;
            this.getAllRadios().map(radio => (radio.checked = false));
            radios[index].focus();
            radios[index].checked = true;
            event.preventDefault();
        }
    }
    // Prevent clicks on the label from briefly blurring the input
    handleMouseDown(event) {
        if (this.edit)
            return true;
        event.preventDefault();
        this.input.focus();
    }
    componentDidLoad() {
        this.formController = new FormSubmitController(this.el, {
            value: (control) => (control.checked ? control.value : undefined),
        }).addFormData();
    }
    disconnectedCallback() {
        var _a;
        (_a = this.formController) === null || _a === void 0 ? void 0 : _a.removeFormData();
    }
    render() {
        const Tag = this.edit ? 'div' : 'label';
        return (h(Tag, { key: '55a994c31898a323fcba732cbf441ffef4da9f42', part: "base", class: {
                'radio': true,
                'radio--checked': this.checked,
                'radio--disabled': this.disabled,
                'radio--focused': this.hasFocus,
                'radio--editing': this.edit,
            }, htmlFor: this.inputId, onKeyDown: e => this.handleKeyDown(e), onMouseDown: e => this.handleMouseDown(e) }, h("span", { key: 'ab9a4d658ffac73abc6cf2a65be9a2e0c57df667', part: "control", class: "radio__control" }, h("span", { key: 'c0ab78af886d80faef8b0455b0f921c8fcf45621', part: "checked-icon", class: "radio__icon" }, h("svg", { key: 'dfbbdd9c7017529f0ff7c4885c282f2f1853ced5', viewBox: "0 0 16 16" }, h("g", { key: '47b625582d262c80f7e71be4d07c822ecb254290', stroke: "none", "stroke-width": "1", fill: "none", "fill-rule": "evenodd" }, h("g", { key: '9fe1b2d8b9067af73289a7bf709c21cb8d5d6286', fill: "currentColor" }, h("circle", { key: '754b94f11ba22610476c24eb8bd8754b344d9dc4', cx: "8", cy: "8", r: "3.42857143" }))))), h("input", { key: '4699d6810635488ca008e989ccbf364e867245ae', id: this.inputId, ref: el => (this.input = el), type: "radio", name: this.name, value: this.value, checked: this.checked, disabled: this.disabled, required: this.required, "aria-checked": this.checked ? 'true' : 'false', "aria-disabled": this.disabled ? 'true' : 'false', "aria-labelledby": this.labelId, onClick: () => this.handleClick(), onBlur: () => this.handleBlur(), onFocus: () => this.handleFocus() })), h("span", { key: '1b10ba8dfa146527047d21c66b4a692818fe3576', part: "label", id: this.labelId, class: "radio__label" }, h("slot", { key: '13e41053107fede04e30946a23cf2f906417e346' }), h("slot", { key: '34841840d7e9a5a29da0dba39e4a88883438293e', name: "description" }))));
    }
    get el() { return getElement(this); }
    static get watchers() { return {
        "checked": ["handleCheckedChange"]
    }; }
};
ScRadio.style = ScRadioStyle0;

const scRadioGroupCss = ":host{display:block}.radio-group{border:none;padding:0;margin:0;min-width:0}.radio-group .radio-group__label{display:inline-block;padding:0;color:var(--sc-input-label-color);font-weight:var(--sc-input-label-font-weight);text-transform:var(--sc-input-label-text-transform, none);letter-spacing:var(--sc-input-label-letter-spacing, 0);margin-bottom:var(--sc-input-label-margin)}.radio-group__hidden-input{position:absolute;opacity:0;padding:0px;margin:0px;pointer-events:none}.radio-group--is-required .radio-group__label:after{content:\" *\";color:var(--sc-color-danger-500)}::slotted(sc-radio:not(:last-of-type)){display:block;margin-bottom:var(--sc-spacing-x-small)}.radio-group--is-rtl.radio-group,.radio-group--is-rtl.radio-group .radio-group__label{text-align:right}";
const ScRadioGroupStyle0 = scRadioGroupCss;

const ScRadioGroup = class {
    constructor(hostRef) {
        registerInstance(this, hostRef);
        this.scChange = createEvent(this, "scChange", 7);
        this.label = '';
        this.invalid = undefined;
        this.value = '';
        this.required = undefined;
    }
    /** Checks for validity and shows the browser's validation message if the control is invalid. */
    async reportValidity() {
        this.invalid = !this.input.checkValidity();
        return this.input.reportValidity();
    }
    handleRadioClick(event) {
        if (event.target.tagName !== 'SC-RADIO')
            return;
        event.stopImmediatePropagation();
        const target = event.target;
        if (target.disabled) {
            return;
        }
        if (target.checked) {
            this.value = target.value;
            this.scChange.emit(target.value);
        }
    }
    componentDidLoad() {
        const choices = [...this.el.querySelectorAll('sc-radio')];
        choices.forEach(choice => {
            if (choice.checked) {
                this.value = choice.value;
            }
        });
    }
    render() {
        return (h("fieldset", { key: '96189b5c62664dc25ed2d7c49a6a019eb5608c01', part: "base", class: {
                'radio-group': true,
                'radio-group--invalid': this.invalid,
                'radio-group--is-required': this.required,
                'radio-group--is-rtl': isRtl(),
            }, "aria-invalid": this.invalid, role: "radiogroup" }, h("legend", { key: '82b0649e08b4d9efc0b5b907cf3dd8b02fe335dc', part: "label", class: "radio-group__label" }, h("slot", { key: '9608785c7451ac42a82b65f8f42376e3c43bdc6c', name: "label" }, this.label)), h("input", { key: 'ef601e66ab99c736e2fefc889ac795b56ad2d848', type: "text", class: "radio-group__hidden-input", ref: el => (this.input = el), required: this.required, value: this.value, tabindex: "-1" }), h("div", { key: '4bcd39663017a7ddbce7e7a1c744902482238941', part: "items", class: "radio-group__items" }, h("slot", { key: '079df2e83a7f266ea9f46645394204183e4db27c' }))));
    }
    get el() { return getElement(this); }
};
ScRadioGroup.style = ScRadioGroupStyle0;

const scShippingChoicesCss = ":host{display:block}.shipping-choice{width:100%;padding:var(--sc-spacing-medium);margin:0;box-sizing:border-box;border-bottom:var(--sc-input-border, 1px solid var(--sc-color-gray-300));background-color:var(--sc-shipping-choice-background-color, var(--sc-input-background-color))}.shipping-choice__empty{background:var(--sc-alert-background-color, var(--sc-color-gray-100));opacity:0.75;padding:var(--sc-spacing-large);border-radius:var(--sc-input-border-radius-medium);line-height:var(--sc-line-height-dense);font-size:var(--sc-font-size-small);border:solid 1px var(--sc-input-border-color, var(--sc-input-border))}.shipping-choice:last-child{border-bottom-width:0}.shipping-choice__text{display:flex;flex-direction:column;gap:var(--sc-spacing-xx-small)}.shipping-choice__price{color:var(--sc-input-label-color);font-weight:var(--sc-price-choice-price-font-weight, var(--sc-font-weight-normal));white-space:nowrap;display:var(--sc-shipping-choice-price-display, inherit)}.shipping-choice__name{display:inline-block;color:var(--sc-price-choice-name-color, var(--sc-input-label-color));font-size:var(--sc-price-choice-name-size, var(--sc-input-label-font-size-medium));font-weight:var(--sc-price-choice-name-font-weight, var(--sc-font-weight-bold));text-transform:var(--sc-price-choice-text-transform, var(--sc-input-label-text-transform, none));line-height:var(--sc-shipping-name-line-height, 1)}.shipping-choice__description{color:var(--sc-input-label-color);font-weight:var(--sc-price-choice-price-font-weight, var(--sc-font-weight-normal));line-height:var(--sc-shipping-description-line-height, 1.2)}sc-radio-group::part(items){border:var(--sc-input-border, 1px solid var(--sc-color-gray-300));border-radius:var(--sc-shipping-choice-border-radius, var(--sc-input-border-radius-medium));box-shadow:var(--sc-shipping-box-shadow, var(--sc-input-box-shadow));overflow:hidden;position:relative}sc-radio::part(base){width:100%}sc-radio::part(label){width:100%;display:flex;justify-content:space-between;gap:var(--sc-spacing-small)}sc-radio-group::slotted(sc-radio:not(:last-of-type)){margin-bottom:0}";
const ScShippingChoicesStyle0 = scShippingChoicesCss;

const ScShippingChoices = class {
    constructor(hostRef) {
        registerInstance(this, hostRef);
        this.label = undefined;
        this.showDescription = true;
    }
    /** Maybe update the order. */
    async updateCheckout(selectedShippingChoiceId) {
        if (!selectedShippingChoiceId)
            return;
        try {
            lockCheckout('selected_shipping_choice');
            state.checkout = (await createOrUpdateCheckout({
                id: state.checkout.id,
                data: {
                    selected_shipping_choice_id: selectedShippingChoiceId,
                },
            }));
            speak(wp.i18n.__('Shipping choice updated.', 'surecart'), 'assertive');
            const { total_amount, currency } = state.checkout;
            /** translators: %1$s: formatted amount */
            speak(wp.i18n.sprintf(wp.i18n.__('Your order total has changed to: %1$s.', 'surecart'), getFormattedPrice({ amount: total_amount, currency })), 'assertive');
        }
        catch (e) {
            console.error(e);
            createErrorNotice(e);
        }
        finally {
            unLockCheckout('selected_shipping_choice');
        }
    }
    render() {
        var _a, _b, _c, _d, _e, _f, _g, _h, _j, _k, _l;
        // shipping choice is not rewquired.
        if (!((_a = state === null || state === void 0 ? void 0 : state.checkout) === null || _a === void 0 ? void 0 : _a.selected_shipping_choice_required)) {
            return h(Host, { style: { display: 'none' } });
        }
        // no shipping choices but no country either
        if (!((_d = (_c = (_b = state === null || state === void 0 ? void 0 : state.checkout) === null || _b === void 0 ? void 0 : _b.shipping_choices) === null || _c === void 0 ? void 0 : _c.data) === null || _d === void 0 ? void 0 : _d.length) && !((_f = (_e = state === null || state === void 0 ? void 0 : state.checkout) === null || _e === void 0 ? void 0 : _e.shipping_address) === null || _f === void 0 ? void 0 : _f.country)) {
            return (h("sc-form-control", { label: this.label || wp.i18n.__('Shipping', 'surecart') }, h("div", { class: "shipping-choice__empty" }, wp.i18n.__('To check available shipping choices, please provide your shipping country in the address section.', 'surecart'))));
        }
        // no shipping choices yet.
        if (!((_j = (_h = (_g = state === null || state === void 0 ? void 0 : state.checkout) === null || _g === void 0 ? void 0 : _g.shipping_choices) === null || _h === void 0 ? void 0 : _h.data) === null || _j === void 0 ? void 0 : _j.length)) {
            return (h("sc-form-control", { part: "empty", label: this.label || wp.i18n.__('Shipping', 'surecart') }, h("div", { class: "shipping-choice__empty" }, wp.i18n.__('Sorry, we are not able to ship to your address.', 'surecart'))));
        }
        return (h(Host, null, h("sc-radio-group", { part: "base", label: this.label || wp.i18n.__('Shipping', 'surecart'), class: "shipping-choices", onScChange: e => this.updateCheckout(e.detail) }, (((_l = (_k = state === null || state === void 0 ? void 0 : state.checkout) === null || _k === void 0 ? void 0 : _k.shipping_choices) === null || _l === void 0 ? void 0 : _l.data) || []).map(({ id, amount, currency, shipping_method }) => {
            var _a;
            return (h("sc-radio", { key: id, checked: ((_a = state === null || state === void 0 ? void 0 : state.checkout) === null || _a === void 0 ? void 0 : _a.selected_shipping_choice) === id, exportparts: "base:radio__base,label:radio__label,control:radio__control,checked-icon:radio__checked-icon", class: "shipping-choice", value: id }, h("div", { class: "shipping-choice__text" }, h("div", { class: "shipping-choice__name" }, (shipping_method === null || shipping_method === void 0 ? void 0 : shipping_method.name) || wp.i18n.__('Standard Shipping', 'surecart')), this.showDescription && !!(shipping_method === null || shipping_method === void 0 ? void 0 : shipping_method.description) && (h("div", { class: "shipping-choice__description" }, shipping_method === null || shipping_method === void 0 ? void 0 : shipping_method.description))), h("div", { class: "shipping-choice__price" }, !!amount ? h("sc-format-number", { type: "currency", value: amount, currency: currency }) : wp.i18n.__('Free', 'surecart'))));
        })), checkoutIsLocked('selected_shipping_choice') && h("sc-block-ui", null)));
    }
};
ScShippingChoices.style = ScShippingChoicesStyle0;

export { ScCompactAddress as sc_compact_address, ScInvoiceDetails as sc_invoice_details, ScLineItemInvoiceMemo as sc_invoice_memo, ScLineItemInvoiceDueDate as sc_line_item_invoice_due_date, ScLineItemInvoiceNumber as sc_line_item_invoice_number, ScLineItemInvoiceReceiptDownload as sc_line_item_invoice_receipt_download, ScLineItemShipping as sc_line_item_shipping, ScLineItemTax as sc_line_item_tax, ScLineItemTrial as sc_line_item_trial, ScOrderBillingAddress as sc_order_billing_address, ScOrderBump as sc_order_bump, ScOrderBumps as sc_order_bumps, ScOrderShippingAddress as sc_order_shipping_address, ScOrderTaxIdInput as sc_order_tax_id_input, ScRadio as sc_radio, ScRadioGroup as sc_radio_group, ScShippingChoices as sc_shipping_choices };

//# sourceMappingURL=sc-compact-address_17.entry.js.map