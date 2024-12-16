'use strict';

Object.defineProperty(exports, '__esModule', { value: true });

const index = require('./index-8acc3c89.js');
const price = require('./price-653ec1cb.js');
require('./currency-71fce0f0.js');

const scPriceCss = ":host{display:block}.price{display:inline-flex;flex-direction:column;gap:var(--sc-spacing-xxx-small);text-align:var(--sc-product-price-alignment, left);justify-content:var(--sc-product-price-alignment, left)}.price__amounts{display:inline-flex;flex-wrap:wrap;align-items:baseline;gap:var(--sc-spacing-xx-small);justify-content:var(--sc-product-price-alignment, left);text-align:var(--sc-product-price-alignment, left)}.price__scratch{text-decoration:line-through;opacity:0.75}.price__interval{font-size:min(var(--sc-font-size-small), 16px);opacity:0.75}.price__details{font-size:min(var(--sc-font-size-small), 16px);opacity:0.75}.price__sale-badge{font-size:min(1em, 14px);align-self:center}";
const ScPriceStyle0 = scPriceCss;

const ScProductPrice = class {
    constructor(hostRef) {
        index.registerInstance(this, hostRef);
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
            return index.h(index.Host, { role: "paragraph" }, wp.i18n.__('Custom Amount', 'surecart'));
        }
        return (index.h(index.Host, { role: "paragraph" }, index.h("div", { class: "price", id: "price" }, index.h("div", { class: "price__amounts" }, !!this.scratchAmount && this.scratchAmount !== this.amount && (index.h(index.Fragment, null, this.scratchAmount === 0 ? (wp.i18n.__('Free', 'surecart')) : (index.h(index.Fragment, null, index.h("sc-visually-hidden", null, wp.i18n.__('The price was', 'surecart'), " "), index.h("sc-format-number", { class: "price__scratch", part: "price__scratch", type: "currency", currency: this.currency, value: this.scratchAmount }), index.h("sc-visually-hidden", null, " ", wp.i18n.__('now discounted to', 'surecart')))))), this.amount === 0 ? wp.i18n.__('Free', 'surecart') : index.h("sc-format-number", { class: "price__amount", type: "currency", value: this.amount, currency: this.currency }), index.h("div", { class: "price__interval" }, this.recurringPeriodCount && 1 < this.recurringPeriodCount && (index.h("sc-visually-hidden", null, ' ', wp.i18n.__('This is a repeating price. Payment will happen', 'surecart'), ' ', price.intervalString({
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
        }))), index.h("span", { "aria-hidden": "true" }, price.intervalString({
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
        }))), !!this.scratchAmount && (index.h("sc-tag", { type: "primary", pill: true, class: "price__sale-badge" }, this.saleText || (index.h(index.Fragment, null, index.h("sc-visually-hidden", null, wp.i18n.__('This product is available for sale.', 'surecart'), " "), index.h("span", { "aria-hidden": "true" }, wp.i18n.__('Sale', 'surecart'))))))), (!!(this === null || this === void 0 ? void 0 : this.trialDurationDays) || !!(this === null || this === void 0 ? void 0 : this.setupFeeAmount)) && (index.h("div", { class: "price__details" }, !!(this === null || this === void 0 ? void 0 : this.trialDurationDays) && (index.h(index.Fragment, null, index.h("sc-visually-hidden", null, wp.i18n.sprintf(wp.i18n.__('You have a %d-day trial before payment becomes necessary.', 'surecart'), this === null || this === void 0 ? void 0 : this.trialDurationDays)), index.h("span", { class: "price__trial", "aria-hidden": "true" }, wp.i18n.sprintf(wp.i18n._n('Starting in %s day.', 'Starting in %s days.', this === null || this === void 0 ? void 0 : this.trialDurationDays, 'surecart'), this === null || this === void 0 ? void 0 : this.trialDurationDays)))), !!(this === null || this === void 0 ? void 0 : this.setupFeeAmount) && (index.h("span", { class: "price__setup-fee" }, index.h("sc-visually-hidden", null, wp.i18n.__('This product has', 'surecart'), " "), ' ', index.h("sc-format-number", { type: "currency", value: this === null || this === void 0 ? void 0 : this.setupFeeAmount, currency: this.currency }), " ", (this === null || this === void 0 ? void 0 : this.setupFeeName) || wp.i18n.__('Setup Fee', 'surecart'), ".")))))));
    }
};
ScProductPrice.style = ScPriceStyle0;

exports.sc_price = ScProductPrice;

//# sourceMappingURL=sc-price.cjs.entry.js.map