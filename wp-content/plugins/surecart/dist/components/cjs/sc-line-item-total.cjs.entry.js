'use strict';

Object.defineProperty(exports, '__esModule', { value: true });

const index = require('./index-8acc3c89.js');
const getters = require('./getters-690e042a.js');
const mutations = require('./mutations-19357660.js');
require('./store-1fb3d249.js');
require('./index-bcdafe6e.js');
require('./utils-ee1bb9d3.js');
require('./remove-query-args-b57e8cd3.js');
require('./add-query-args-49dcb630.js');
require('./index-fb76df07.js');
require('./google-59d23803.js');
require('./currency-71fce0f0.js');
require('./price-653ec1cb.js');

const scLineItemTotalCss = ":host{display:block}sc-line-item{text-align:left}.line-item-total__group sc-line-item{margin:4px 0px !important}.scratch-price{text-decoration:line-through;color:var(--sc-color-gray-500);font-size:var(--sc-font-size-small);margin-right:var(--sc-spacing-xx-small)}sc-line-item::part(base){grid-template-columns:max-content auto auto}.total-price{white-space:nowrap}";
const ScLineItemTotalStyle0 = scLineItemTotalCss;

const ScLineItemTotal = class {
    constructor(hostRef) {
        index.registerInstance(this, hostRef);
        this.order_key = {
            total: 'total_amount',
            subtotal: 'subtotal_amount',
            amount_due: 'amount_due',
        };
        this.total = 'total';
        this.size = undefined;
        this.checkout = undefined;
    }
    hasInstallmentPlan(checkout) {
        return (checkout === null || checkout === void 0 ? void 0 : checkout.full_amount) !== (checkout === null || checkout === void 0 ? void 0 : checkout.subtotal_amount);
    }
    hasSubscription(checkout) {
        var _a;
        return (((_a = checkout === null || checkout === void 0 ? void 0 : checkout.line_items) === null || _a === void 0 ? void 0 : _a.data) || []).some(lineItem => { var _a, _b, _c; return ((_a = lineItem === null || lineItem === void 0 ? void 0 : lineItem.price) === null || _a === void 0 ? void 0 : _a.recurring_interval) === 'month' && !!((_b = lineItem === null || lineItem === void 0 ? void 0 : lineItem.price) === null || _b === void 0 ? void 0 : _b.recurring_interval) && !((_c = lineItem === null || lineItem === void 0 ? void 0 : lineItem.price) === null || _c === void 0 ? void 0 : _c.recurring_period_count); });
    }
    renderLineItemTitle(checkout) {
        if (this.total === 'total' && this.hasInstallmentPlan(checkout)) {
            return (index.h("span", { slot: "title" }, index.h("slot", { name: "first-payment-total-description" }, wp.i18n.__('Subtotal', 'surecart'))));
        }
        return (index.h("span", { slot: "title" }, index.h("slot", { name: "title" })));
    }
    renderLineItemDescription(checkout) {
        if (this.total === 'subtotal' && this.hasInstallmentPlan(checkout)) {
            return (index.h("span", { slot: "description" }, index.h("slot", { name: "first-payment-subtotal-description" }, wp.i18n.__('Initial Payment', 'surecart'))));
        }
        return (index.h("span", { slot: "description" }, index.h("slot", { name: "description" })));
    }
    render() {
        var _a;
        const checkout = this.checkout || (mutations.state === null || mutations.state === void 0 ? void 0 : mutations.state.checkout);
        // loading state
        if (getters.formBusy() && !(checkout === null || checkout === void 0 ? void 0 : checkout[(_a = this === null || this === void 0 ? void 0 : this.order_key) === null || _a === void 0 ? void 0 : _a[this === null || this === void 0 ? void 0 : this.total]])) {
            return (index.h("sc-line-item", null, index.h("sc-skeleton", { slot: "title", style: { width: '120px', display: 'inline-block' } }), index.h("sc-skeleton", { slot: "price", style: { 'width': '70px', 'display': 'inline-block', 'height': this.size === 'large' ? '40px' : '', '--border-radius': '6px' } })));
        }
        if (!(checkout === null || checkout === void 0 ? void 0 : checkout.currency))
            return;
        // if the total amount is different than the amount due.
        if (this.total === 'total' && (checkout === null || checkout === void 0 ? void 0 : checkout.total_amount) !== (checkout === null || checkout === void 0 ? void 0 : checkout.amount_due)) {
            return (index.h("div", { class: "line-item-total__group" }, index.h("sc-line-item", null, index.h("span", { slot: "description" }, this.hasInstallmentPlan(checkout) ? (this.renderLineItemTitle(checkout)) : (index.h(index.Fragment, null, index.h("slot", { name: "title" }), index.h("slot", { name: "description" })))), index.h("span", { slot: "price" }, index.h("sc-total", { order: checkout, total: this.total }))), !!checkout.trial_amount && (index.h("sc-line-item", null, index.h("span", { slot: "description" }, index.h("slot", { name: "free-trial-description" }, wp.i18n.__('Trial', 'surecart'))), index.h("span", { slot: "price" }, index.h("sc-format-number", { type: "currency", value: checkout.trial_amount, currency: checkout.currency })))), index.h("sc-line-item", { style: { '--price-size': 'var(--sc-font-size-x-large)' } }, this.hasSubscription(checkout) ? (index.h("span", { slot: "title" }, index.h("slot", { name: "subscription-title" }, wp.i18n.__('Total Due Today', 'surecart')))) : (index.h("span", { slot: "title" }, index.h("slot", { name: "due-amount-description" }, wp.i18n.__('Amount Due', 'surecart')))), index.h("span", { slot: "price" }, index.h("sc-format-number", { type: "currency", currency: checkout === null || checkout === void 0 ? void 0 : checkout.currency, value: checkout === null || checkout === void 0 ? void 0 : checkout.amount_due })))));
        }
        return (index.h(index.Fragment, null, this.total === 'subtotal' && this.hasInstallmentPlan(checkout) && (index.h("sc-line-item", { style: this.size === 'large' ? { '--price-size': 'var(--sc-font-size-x-large)' } : {} }, index.h("span", { slot: "description" }, index.h("slot", { name: "total-payments-description" }, wp.i18n.__('Total Installment Payments', 'surecart'))), index.h("span", { slot: "price" }, index.h("sc-format-number", { type: "currency", value: checkout === null || checkout === void 0 ? void 0 : checkout.full_amount, currency: (checkout === null || checkout === void 0 ? void 0 : checkout.currency) || 'usd' })))), index.h("sc-line-item", { style: this.size === 'large' ? { '--price-size': 'var(--sc-font-size-x-large)' } : {} }, this.renderLineItemTitle(checkout), this.renderLineItemDescription(checkout), index.h("span", { slot: "price" }, !!(checkout === null || checkout === void 0 ? void 0 : checkout.total_savings_amount) && this.total === 'total' && (index.h("sc-format-number", { class: "scratch-price", type: "currency", value: -(checkout === null || checkout === void 0 ? void 0 : checkout.total_savings_amount) + (checkout === null || checkout === void 0 ? void 0 : checkout.total_amount), currency: (checkout === null || checkout === void 0 ? void 0 : checkout.currency) || 'usd' })), index.h("sc-total", { class: "total-price", order: checkout, total: this.total })))));
    }
};
ScLineItemTotal.style = ScLineItemTotalStyle0;

exports.sc_line_item_total = ScLineItemTotal;

//# sourceMappingURL=sc-line-item-total.cjs.entry.js.map