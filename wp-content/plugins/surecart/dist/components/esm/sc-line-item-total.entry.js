import { r as registerInstance, h, F as Fragment } from './index-745b6bec.js';
import { f as formBusy } from './getters-929aa1df.js';
import { s as state } from './mutations-d5e8faea.js';
import './store-7020541e.js';
import './index-06061d4e.js';
import './utils-e9ee502a.js';
import './remove-query-args-938c53ea.js';
import './add-query-args-0e2a8393.js';
import './index-c5a96d53.js';
import './google-a86aa761.js';
import './currency-a0c9bff4.js';
import './price-d5770168.js';

const scLineItemTotalCss = ":host{display:block}sc-line-item{text-align:left}.line-item-total__group sc-line-item{margin:4px 0px !important}.scratch-price{text-decoration:line-through;color:var(--sc-color-gray-500);font-size:var(--sc-font-size-small);margin-right:var(--sc-spacing-xx-small)}sc-line-item::part(base){grid-template-columns:max-content auto auto}.total-price{white-space:nowrap}";
const ScLineItemTotalStyle0 = scLineItemTotalCss;

const ScLineItemTotal = class {
    constructor(hostRef) {
        registerInstance(this, hostRef);
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
            return (h("span", { slot: "title" }, h("slot", { name: "first-payment-total-description" }, wp.i18n.__('Subtotal', 'surecart'))));
        }
        return (h("span", { slot: "title" }, h("slot", { name: "title" })));
    }
    renderLineItemDescription(checkout) {
        if (this.total === 'subtotal' && this.hasInstallmentPlan(checkout)) {
            return (h("span", { slot: "description" }, h("slot", { name: "first-payment-subtotal-description" }, wp.i18n.__('Initial Payment', 'surecart'))));
        }
        return (h("span", { slot: "description" }, h("slot", { name: "description" })));
    }
    render() {
        var _a;
        const checkout = this.checkout || (state === null || state === void 0 ? void 0 : state.checkout);
        // loading state
        if (formBusy() && !(checkout === null || checkout === void 0 ? void 0 : checkout[(_a = this === null || this === void 0 ? void 0 : this.order_key) === null || _a === void 0 ? void 0 : _a[this === null || this === void 0 ? void 0 : this.total]])) {
            return (h("sc-line-item", null, h("sc-skeleton", { slot: "title", style: { width: '120px', display: 'inline-block' } }), h("sc-skeleton", { slot: "price", style: { 'width': '70px', 'display': 'inline-block', 'height': this.size === 'large' ? '40px' : '', '--border-radius': '6px' } })));
        }
        if (!(checkout === null || checkout === void 0 ? void 0 : checkout.currency))
            return;
        // if the total amount is different than the amount due.
        if (this.total === 'total' && (checkout === null || checkout === void 0 ? void 0 : checkout.total_amount) !== (checkout === null || checkout === void 0 ? void 0 : checkout.amount_due)) {
            return (h("div", { class: "line-item-total__group" }, h("sc-line-item", null, h("span", { slot: "description" }, this.hasInstallmentPlan(checkout) ? (this.renderLineItemTitle(checkout)) : (h(Fragment, null, h("slot", { name: "title" }), h("slot", { name: "description" })))), h("span", { slot: "price" }, h("sc-total", { order: checkout, total: this.total }))), !!checkout.trial_amount && (h("sc-line-item", null, h("span", { slot: "description" }, h("slot", { name: "free-trial-description" }, wp.i18n.__('Trial', 'surecart'))), h("span", { slot: "price" }, h("sc-format-number", { type: "currency", value: checkout.trial_amount, currency: checkout.currency })))), h("sc-line-item", { style: { '--price-size': 'var(--sc-font-size-x-large)' } }, this.hasSubscription(checkout) ? (h("span", { slot: "title" }, h("slot", { name: "subscription-title" }, wp.i18n.__('Total Due Today', 'surecart')))) : (h("span", { slot: "title" }, h("slot", { name: "due-amount-description" }, wp.i18n.__('Amount Due', 'surecart')))), h("span", { slot: "price" }, h("sc-format-number", { type: "currency", currency: checkout === null || checkout === void 0 ? void 0 : checkout.currency, value: checkout === null || checkout === void 0 ? void 0 : checkout.amount_due })))));
        }
        return (h(Fragment, null, this.total === 'subtotal' && this.hasInstallmentPlan(checkout) && (h("sc-line-item", { style: this.size === 'large' ? { '--price-size': 'var(--sc-font-size-x-large)' } : {} }, h("span", { slot: "description" }, h("slot", { name: "total-payments-description" }, wp.i18n.__('Total Installment Payments', 'surecart'))), h("span", { slot: "price" }, h("sc-format-number", { type: "currency", value: checkout === null || checkout === void 0 ? void 0 : checkout.full_amount, currency: (checkout === null || checkout === void 0 ? void 0 : checkout.currency) || 'usd' })))), h("sc-line-item", { style: this.size === 'large' ? { '--price-size': 'var(--sc-font-size-x-large)' } : {} }, this.renderLineItemTitle(checkout), this.renderLineItemDescription(checkout), h("span", { slot: "price" }, !!(checkout === null || checkout === void 0 ? void 0 : checkout.total_savings_amount) && this.total === 'total' && (h("sc-format-number", { class: "scratch-price", type: "currency", value: -(checkout === null || checkout === void 0 ? void 0 : checkout.total_savings_amount) + (checkout === null || checkout === void 0 ? void 0 : checkout.total_amount), currency: (checkout === null || checkout === void 0 ? void 0 : checkout.currency) || 'usd' })), h("sc-total", { class: "total-price", order: checkout, total: this.total })))));
    }
};
ScLineItemTotal.style = ScLineItemTotalStyle0;

export { ScLineItemTotal as sc_line_item_total };

//# sourceMappingURL=sc-line-item-total.entry.js.map