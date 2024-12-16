'use strict';

Object.defineProperty(exports, '__esModule', { value: true });

const index = require('./index-8acc3c89.js');
const consumer = require('./consumer-9f4ee0e3.js');

const scDonationChoicesCss = ":host{display:block}.sc-donation-choices{display:grid;gap:var(--sc-spacing-small);position:relative}.sc-donation-choices__form{display:grid;gap:var(--sc-spacing-small)}";
const ScDonationChoicesStyle0 = scDonationChoicesCss;

const ScDonationChoices = class {
    constructor(hostRef) {
        index.registerInstance(this, hostRef);
        this.scRemoveLineItem = index.createEvent(this, "scRemoveLineItem", 7);
        this.scUpdateLineItem = index.createEvent(this, "scUpdateLineItem", 7);
        this.scAddLineItem = index.createEvent(this, "scAddLineItem", 7);
        this.priceId = undefined;
        this.defaultAmount = undefined;
        this.currencyCode = 'usd';
        this.lineItems = [];
        this.loading = undefined;
        this.busy = undefined;
        this.removeInvalid = true;
        this.label = undefined;
        this.lineItem = undefined;
        this.error = undefined;
        this.showCustomAmount = undefined;
    }
    async reportValidity() {
        if (!this.input)
            return true;
        return this.input.shadowRoot.querySelector('sc-input').reportValidity();
    }
    handleChange() {
        const checked = Array.from(this.getChoices()).find(item => item.checked);
        this.showCustomAmount = checked.value === 'ad_hoc';
        if (!isNaN(parseInt(checked.value))) {
            this.scUpdateLineItem.emit({ price_id: this.priceId, quantity: 1, ad_hoc_amount: parseInt(checked.value) });
        }
    }
    handleCustomAmountToggle(val) {
        if (val) {
            setTimeout(() => {
                var _a, _b;
                (_b = (_a = this.input) === null || _a === void 0 ? void 0 : _a.triggerFocus) === null || _b === void 0 ? void 0 : _b.call(_a);
            }, 50);
        }
    }
    /** Store current line item in state. */
    handleLineItemsChange() {
        var _a;
        if (!((_a = this.lineItems) === null || _a === void 0 ? void 0 : _a.length))
            return;
        this.lineItem = (this.lineItems || []).find(lineItem => lineItem.price.id === this.priceId);
    }
    handleLineItemChange(val) {
        this.removeInvalid && this.removeInvalidPrices();
        const choices = this.getChoices();
        let hasCheckedOption = false;
        // check the correct option.
        choices.forEach((el) => {
            if (isNaN(parseInt(el.value)) || el.disabled)
                return;
            if (parseInt(el.value) === (val === null || val === void 0 ? void 0 : val.ad_hoc_amount)) {
                el.checked = true;
                hasCheckedOption = true;
            }
            else {
                el.checked = false;
            }
        });
        this.showCustomAmount = !hasCheckedOption;
        // no options are checked, let's fill in the input.
        if (!hasCheckedOption) {
            this.el.querySelector('sc-choice[value="ad_hoc"]').checked = true;
        }
    }
    componentWillLoad() {
        this.handleLineItemsChange();
    }
    selectDefaultChoice() {
        const choices = this.getChoices();
        if (!choices.length)
            return;
        choices[0].checked = true;
    }
    getChoices() {
        return this.el.querySelectorAll('sc-choice') || [];
    }
    removeInvalidPrices() {
        if (!this.lineItem)
            return;
        this.getChoices().forEach((el) => {
            var _a, _b, _c, _d, _e, _f, _g, _h;
            // we have a max and the value is more.
            if (((_b = (_a = this.lineItem) === null || _a === void 0 ? void 0 : _a.price) === null || _b === void 0 ? void 0 : _b.ad_hoc_max_amount) && parseInt(el.value) > ((_d = (_c = this.lineItem) === null || _c === void 0 ? void 0 : _c.price) === null || _d === void 0 ? void 0 : _d.ad_hoc_max_amount)) {
                el.style.display = 'none';
                el.disabled = true;
                return;
            }
            // we have a min and the value is less.
            if (((_f = (_e = this.lineItem) === null || _e === void 0 ? void 0 : _e.price) === null || _f === void 0 ? void 0 : _f.ad_hoc_min_amount) && parseInt(el.value) < ((_h = (_g = this.lineItem) === null || _g === void 0 ? void 0 : _g.price) === null || _h === void 0 ? void 0 : _h.ad_hoc_min_amount)) {
                el.style.display = 'none';
                el.disabled = true;
                return;
            }
            el.style.display = 'flex';
            el.disabled = false;
        });
    }
    updateCustomAmount() {
        var _a, _b, _c;
        if (this.input.value === ((_c = (_b = (_a = this.lineItem) === null || _a === void 0 ? void 0 : _a.ad_hoc_amount) === null || _b === void 0 ? void 0 : _b.toString) === null || _c === void 0 ? void 0 : _c.call(_b)))
            return;
        this.input.value
            ? this.scUpdateLineItem.emit({ price_id: this.priceId, quantity: 1, ad_hoc_amount: parseInt(this.input.value) })
            : this.scRemoveLineItem.emit({ price_id: this.priceId, quantity: 1 });
    }
    render() {
        var _a, _b, _c;
        if (this.loading) {
            return (index.h("div", { class: "sc-donation-choices" }, index.h("sc-skeleton", { style: { width: '20%', display: 'inline-block' } }), index.h("sc-skeleton", { style: { width: '60%', display: 'inline-block' } }), index.h("sc-skeleton", { style: { width: '40%', display: 'inline-block' } })));
        }
        return (index.h("div", { class: "sc-donation-choices" }, index.h("sc-choices", { label: this.label, "auto-width": true }, index.h("slot", null)), this.showCustomAmount && (index.h("div", { class: "sc-donation-choices__form" }, index.h("sc-price-input", { ref: el => (this.input = el), required: true, currencyCode: this.currencyCode, label: 'Enter an amount', value: (_c = (_b = (_a = this.lineItem) === null || _a === void 0 ? void 0 : _a.ad_hoc_amount) === null || _b === void 0 ? void 0 : _b.toString) === null || _c === void 0 ? void 0 : _c.call(_b) }), index.h("sc-button", { type: "primary", onClick: () => this.updateCustomAmount(), full: true, busy: this.busy }, wp.i18n.__('Update', 'surecart')))), this.busy && index.h("sc-block-ui", { style: { zIndex: '9' } })));
    }
    get el() { return index.getElement(this); }
    static get watchers() { return {
        "showCustomAmount": ["handleCustomAmountToggle"],
        "lineItems": ["handleLineItemsChange"],
        "lineItem": ["handleLineItemChange"]
    }; }
};
consumer.openWormhole(ScDonationChoices, ['lineItems', 'loading', 'busy', 'currencyCode'], false);
ScDonationChoices.style = ScDonationChoicesStyle0;

exports.sc_donation_choices = ScDonationChoices;

//# sourceMappingURL=sc-donation-choices.cjs.entry.js.map