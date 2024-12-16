import { r as registerInstance, h, H as Host, F as Fragment } from './index-745b6bec.js';
import { i as intervalString } from './price-d5770168.js';
import './currency-a0c9bff4.js';

const scPriceCss = ":host{display:block}.price{display:inline-flex;flex-direction:column;gap:var(--sc-spacing-xxx-small);text-align:var(--sc-product-price-alignment, left);justify-content:var(--sc-product-price-alignment, left)}.price__amounts{display:inline-flex;flex-wrap:wrap;align-items:baseline;gap:var(--sc-spacing-xx-small);justify-content:var(--sc-product-price-alignment, left);text-align:var(--sc-product-price-alignment, left)}.price__scratch{text-decoration:line-through;opacity:0.75}.price__interval{font-size:min(var(--sc-font-size-small), 16px);opacity:0.75}.price__details{font-size:min(var(--sc-font-size-small), 16px);opacity:0.75}.price__sale-badge{font-size:min(1em, 14px);align-self:center}";
const ScPriceStyle0 = scPriceCss;

const ScProductPrice = class {
    constructor(hostRef) {
        registerInstance(this, hostRef);
        this.currency = undefined;
        this.amount = undefined;
        this.scratchAmount = undefined;
        this.saleText = undefined;
        this.adHoc = undefined;
        this.recurringPeriodCount = undefined;
        this.recurringIntervalCount = undefined;
        this.recurringInterval = undefined;
        this.setupFeeAmount = undefined;
        this.trialDurationDays = undefined;
        this.setupFeeName = undefined;
    }
    render() {
        if (this.adHoc) {
            return h(Host, { role: "paragraph" }, wp.i18n.__('Custom Amount', 'surecart'));
        }
        return (h(Host, { role: "paragraph" }, h("div", { class: "price", id: "price" }, h("div", { class: "price__amounts" }, !!this.scratchAmount && this.scratchAmount !== this.amount && (h(Fragment, null, this.scratchAmount === 0 ? (wp.i18n.__('Free', 'surecart')) : (h(Fragment, null, h("sc-visually-hidden", null, wp.i18n.__('The price was', 'surecart'), " "), h("sc-format-number", { class: "price__scratch", part: "price__scratch", type: "currency", currency: this.currency, value: this.scratchAmount }), h("sc-visually-hidden", null, " ", wp.i18n.__('now discounted to', 'surecart')))))), this.amount === 0 ? wp.i18n.__('Free', 'surecart') : h("sc-format-number", { class: "price__amount", type: "currency", value: this.amount, currency: this.currency }), h("div", { class: "price__interval" }, this.recurringPeriodCount && 1 < this.recurringPeriodCount && (h("sc-visually-hidden", null, ' ', wp.i18n.__('This is a repeating price. Payment will happen', 'surecart'), ' ', intervalString({
            recurring_interval_count: this.recurringIntervalCount,
            recurring_interval: this.recurringInterval,
            recurring_period_count: this.recurringPeriodCount,
        }, {
            showOnce: true,
            abbreviate: false,
            labels: {
                interval: wp.i18n.__('every', 'surecart'),
                period: 
                /** translators: used as in time period: "for 3 months" */
                wp.i18n.__('for', 'surecart'),
            },
        }))), h("span", { "aria-hidden": "true" }, intervalString({
            recurring_interval_count: this.recurringIntervalCount,
            recurring_interval: this.recurringInterval,
            recurring_period_count: this.recurringPeriodCount,
        }, {
            showOnce: true,
            abbreviate: false,
            labels: {
                interval: '/',
                period: 
                /** translators: used as in time period: "for 3 months" */
                wp.i18n.__('for', 'surecart'),
            },
        }))), !!this.scratchAmount && (h("sc-tag", { type: "primary", pill: true, class: "price__sale-badge" }, this.saleText || (h(Fragment, null, h("sc-visually-hidden", null, wp.i18n.__('This product is available for sale.', 'surecart'), " "), h("span", { "aria-hidden": "true" }, wp.i18n.__('Sale', 'surecart'))))))), (!!(this === null || this === void 0 ? void 0 : this.trialDurationDays) || !!(this === null || this === void 0 ? void 0 : this.setupFeeAmount)) && (h("div", { class: "price__details" }, !!(this === null || this === void 0 ? void 0 : this.trialDurationDays) && (h(Fragment, null, h("sc-visually-hidden", null, wp.i18n.sprintf(wp.i18n.__('You have a %d-day trial before payment becomes necessary.', 'surecart'), this === null || this === void 0 ? void 0 : this.trialDurationDays)), h("span", { class: "price__trial", "aria-hidden": "true" }, wp.i18n.sprintf(wp.i18n._n('Starting in %s day.', 'Starting in %s days.', this === null || this === void 0 ? void 0 : this.trialDurationDays, 'surecart'), this === null || this === void 0 ? void 0 : this.trialDurationDays)))), !!(this === null || this === void 0 ? void 0 : this.setupFeeAmount) && (h("span", { class: "price__setup-fee" }, h("sc-visually-hidden", null, wp.i18n.__('This product has', 'surecart'), " "), ' ', h("sc-format-number", { type: "currency", value: this === null || this === void 0 ? void 0 : this.setupFeeAmount, currency: this.currency }), " ", (this === null || this === void 0 ? void 0 : this.setupFeeName) || wp.i18n.__('Setup Fee', 'surecart'), ".")))))));
    }
};
ScProductPrice.style = ScPriceStyle0;

export { ScProductPrice as sc_price };

//# sourceMappingURL=sc-price.entry.js.map