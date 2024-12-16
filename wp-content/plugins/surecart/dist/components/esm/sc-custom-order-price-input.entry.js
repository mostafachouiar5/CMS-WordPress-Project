import { r as registerInstance, c as createEvent, h, H as Host } from './index-745b6bec.js';
import { a as apiFetch } from './fetch-2032d11d.js';
import { o as openWormhole } from './consumer-e06b16d3.js';
import './add-query-args-0e2a8393.js';
import './remove-query-args-938c53ea.js';

const scCustomOrderPriceInputCss = "sc-custom-order-price-input{display:block}";
const ScCustomOrderPriceInputStyle0 = scCustomOrderPriceInputCss;

const ScCustomOrderPriceInput = class {
    constructor(hostRef) {
        registerInstance(this, hostRef);
        this.scUpdateLineItem = createEvent(this, "scUpdateLineItem", 7);
        this.priceId = undefined;
        this.price = undefined;
        this.loading = false;
        this.busy = false;
        this.label = undefined;
        this.placeholder = undefined;
        this.required = undefined;
        this.help = undefined;
        this.showCode = undefined;
        this.lineItems = [];
        this.fetching = false;
        this.lineItem = undefined;
    }
    handleBlur(e) {
        var _a;
        const ad_hoc_amount = parseInt(e.target.value);
        if (isNaN(ad_hoc_amount))
            return;
        if (((_a = this.lineItem) === null || _a === void 0 ? void 0 : _a.ad_hoc_amount) === ad_hoc_amount)
            return;
        this.scUpdateLineItem.emit({ price_id: this.priceId, quantity: 1, ad_hoc_amount });
    }
    /** Store current line item in state. */
    handleLineItemsChange() {
        var _a;
        if (!((_a = this.lineItems) === null || _a === void 0 ? void 0 : _a.length))
            return;
        this.lineItem = (this.lineItems || []).find(lineItem => lineItem.price.id === this.priceId);
    }
    componentDidLoad() {
        if (!this.price) {
            this.fetchPrice();
        }
    }
    /** Fetch prices and products */
    async fetchPrice() {
        if (!this.priceId)
            return;
        try {
            this.fetching = true;
            this.price = (await apiFetch({
                path: `surecart/v1/prices/${this.priceId}`,
            }));
        }
        catch (err) {
        }
        finally {
            this.fetching = false;
        }
    }
    renderEmpty() {
        var _a;
        if ((_a = window === null || window === void 0 ? void 0 : window.wp) === null || _a === void 0 ? void 0 : _a.blocks) {
            return (h("sc-alert", { type: "danger", open: true, style: { margin: '0px' } }, wp.i18n.__('This price has been archived.', 'surecart')));
        }
        return h(Host, { style: { display: 'none' } });
    }
    render() {
        var _a, _b, _c, _d, _e, _f;
        if (this.loading || this.fetching) {
            return (h("div", null, h("sc-skeleton", { style: { width: '20%', marginBottom: '0.75em' } }), h("sc-skeleton", { style: { width: '100%' } })));
        }
        // Price needs to be active.
        if (!((_a = this === null || this === void 0 ? void 0 : this.price) === null || _a === void 0 ? void 0 : _a.id) || ((_b = this.price) === null || _b === void 0 ? void 0 : _b.archived))
            return this.renderEmpty();
        return (h("div", { class: "sc-custom-order-price-input" }, h("sc-price-input", { "currency-code": ((_c = this.price) === null || _c === void 0 ? void 0 : _c.currency) || 'usd', label: this.label, min: (_d = this === null || this === void 0 ? void 0 : this.price) === null || _d === void 0 ? void 0 : _d.ad_hoc_min_amount, max: (_e = this === null || this === void 0 ? void 0 : this.price) === null || _e === void 0 ? void 0 : _e.ad_hoc_max_amount, placeholder: this.placeholder, required: this.required, value: (_f = this.lineItem) === null || _f === void 0 ? void 0 : _f.ad_hoc_amount.toString(), "show-code": this.showCode, help: this.help }), this.busy && h("sc-block-ui", { style: { zIndex: '9' } })));
    }
    static get watchers() { return {
        "lineItems": ["handleLineItemsChange"]
    }; }
};
openWormhole(ScCustomOrderPriceInput, ['busy', 'lineItems'], false);
ScCustomOrderPriceInput.style = ScCustomOrderPriceInputStyle0;

export { ScCustomOrderPriceInput as sc_custom_order_price_input };

//# sourceMappingURL=sc-custom-order-price-input.entry.js.map