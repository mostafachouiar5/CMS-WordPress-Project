'use strict';

Object.defineProperty(exports, '__esModule', { value: true });

const index = require('./index-8acc3c89.js');
const fetch = require('./fetch-f25a0cb0.js');
const lazy = require('./lazy-2b509fa7.js');
const price = require('./price-653ec1cb.js');
const tax = require('./tax-736ff458.js');
const addQueryArgs = require('./add-query-args-49dcb630.js');
require('./remove-query-args-b57e8cd3.js');
require('./currency-71fce0f0.js');

const scOrderCss = ":host{display:block}.order__row{padding:var(--sc-spacing-large);display:grid;gap:var(--sc-spacing-small)}";
const ScOrderStyle0 = scOrderCss;

const ScOrder = class {
    constructor(hostRef) {
        index.registerInstance(this, hostRef);
        this.orderId = undefined;
        this.customerIds = undefined;
        this.heading = undefined;
        this.order = undefined;
        this.purchases = undefined;
        this.loading = undefined;
        this.busy = undefined;
        this.error = undefined;
    }
    /** Only fetch if visible */
    componentDidLoad() {
        lazy.onFirstVisible(this.el, () => {
            this.fetchOrder();
            this.fetchDownloads();
        });
    }
    async fetchOrder() {
        try {
            this.loading = true;
            await this.getOrder();
        }
        catch (e) {
            console.error(this.error);
            this.error = (e === null || e === void 0 ? void 0 : e.message) || wp.i18n.__('Something went wrong', 'surecart');
        }
        finally {
            this.loading = false;
        }
    }
    async fetchDownloads() {
        try {
            this.busy = true;
            this.purchases = (await fetch.apiFetch({
                path: addQueryArgs.addQueryArgs(`surecart/v1/purchases`, {
                    expand: ['product', 'product.downloads', 'download.media'],
                    order_ids: [this.orderId],
                    customer_ids: this.customerIds,
                    downloadable: true,
                }),
            }));
        }
        catch (e) {
            console.error(this.error);
            this.error = (e === null || e === void 0 ? void 0 : e.message) || wp.i18n.__('Something went wrong', 'surecart');
        }
        finally {
            this.busy = false;
        }
    }
    /** Get order */
    async getOrder() {
        this.order = (await fetch.apiFetch({
            path: addQueryArgs.addQueryArgs(`surecart/v1/orders/${this.orderId}`, {
                expand: [
                    'checkout',
                    'checkout.line_items',
                    'line_item.price',
                    'line_item.fees',
                    'line_item.variant',
                    'variant.image',
                    'price.product',
                    'checkout.manual_payment_method',
                    'checkout.payment_method',
                    'checkout.selected_shipping_choice',
                    'shipping_choice.shipping_method',
                    'payment_method.card',
                    'payment_method.payment_instrument',
                    'payment_method.paypal_account',
                    'payment_method.bank_account',
                    'checkout.discount',
                    'discount.promotion',
                    'checkout.charge',
                ],
            }),
        }));
    }
    renderLoading() {
        return (index.h("sc-flex", { flexDirection: "column", style: { gap: '1em' } }, index.h("sc-skeleton", { style: { width: '20%', display: 'inline-block' } }), index.h("sc-skeleton", { style: { width: '60%', display: 'inline-block' } }), index.h("sc-skeleton", { style: { width: '40%', display: 'inline-block' } })));
    }
    renderEmpty() {
        return index.h("sc-empty", { icon: "shopping-bag" }, wp.i18n.__('Order not found.', 'surecart'));
    }
    renderContent() {
        var _a, _b, _c, _d, _e, _f, _g, _h, _j, _k;
        if (this.loading) {
            return this.renderLoading();
        }
        if (!((_a = this.order) === null || _a === void 0 ? void 0 : _a.id)) {
            return this.renderEmpty();
        }
        const checkout = (_b = this.order) === null || _b === void 0 ? void 0 : _b.checkout;
        const shippingMethod = (_c = checkout === null || checkout === void 0 ? void 0 : checkout.selected_shipping_choice) === null || _c === void 0 ? void 0 : _c.shipping_method;
        const shippingMethodName = shippingMethod === null || shippingMethod === void 0 ? void 0 : shippingMethod.name;
        return (index.h(index.Fragment, null, (((_d = checkout === null || checkout === void 0 ? void 0 : checkout.line_items) === null || _d === void 0 ? void 0 : _d.data) || []).map(item => {
            var _a, _b, _c, _d, _e, _f, _g;
            return (index.h("sc-product-line-item", { key: item.id, image: item === null || item === void 0 ? void 0 : item.image, name: (_b = (_a = item === null || item === void 0 ? void 0 : item.price) === null || _a === void 0 ? void 0 : _a.product) === null || _b === void 0 ? void 0 : _b.name, priceName: (_c = item === null || item === void 0 ? void 0 : item.price) === null || _c === void 0 ? void 0 : _c.name, variantLabel: ((item === null || item === void 0 ? void 0 : item.variant_options) || []).filter(Boolean).join(' / ') || null, editable: false, removable: false, quantity: item.quantity, amount: item.subtotal_amount, currency: (_d = item === null || item === void 0 ? void 0 : item.price) === null || _d === void 0 ? void 0 : _d.currency, trialDurationDays: (_e = item === null || item === void 0 ? void 0 : item.price) === null || _e === void 0 ? void 0 : _e.trial_duration_days, interval: price.intervalString(item === null || item === void 0 ? void 0 : item.price), scratchAmount: item === null || item === void 0 ? void 0 : item.scratch_amount, setupFeeTrialEnabled: (_f = item === null || item === void 0 ? void 0 : item.price) === null || _f === void 0 ? void 0 : _f.setup_fee_trial_enabled, fees: (_g = item === null || item === void 0 ? void 0 : item.fees) === null || _g === void 0 ? void 0 : _g.data }));
        }), index.h("sc-divider", { style: { '--spacing': 'var(--sc-spacing-x-small)' } }), index.h("sc-line-item", null, index.h("span", { slot: "description" }, wp.i18n.__('Subtotal', 'surecart')), index.h("sc-format-number", { slot: "price", style: {
                'font-weight': 'var(--sc-font-weight-semibold)',
                'color': 'var(--sc-color-gray-800)',
            }, type: "currency", currency: checkout === null || checkout === void 0 ? void 0 : checkout.currency, value: checkout === null || checkout === void 0 ? void 0 : checkout.subtotal_amount })), !!(checkout === null || checkout === void 0 ? void 0 : checkout.proration_amount) && (index.h("sc-line-item", null, index.h("span", { slot: "description" }, wp.i18n.__('Proration', 'surecart')), index.h("sc-format-number", { slot: "price", style: {
                'font-weight': 'var(--sc-font-weight-semibold)',
                'color': 'var(--sc-color-gray-800)',
            }, type: "currency", currency: checkout === null || checkout === void 0 ? void 0 : checkout.currency, value: checkout === null || checkout === void 0 ? void 0 : checkout.proration_amount }))), !!(checkout === null || checkout === void 0 ? void 0 : checkout.applied_balance_amount) && (index.h("sc-line-item", null, index.h("span", { slot: "description" }, wp.i18n.__('Applied Balance', 'surecart')), index.h("sc-format-number", { slot: "price", style: {
                'font-weight': 'var(--sc-font-weight-semibold)',
                'color': 'var(--sc-color-gray-800)',
            }, type: "currency", currency: checkout === null || checkout === void 0 ? void 0 : checkout.currency, value: checkout === null || checkout === void 0 ? void 0 : checkout.applied_balance_amount }))), !!(checkout === null || checkout === void 0 ? void 0 : checkout.discounts) && (index.h("sc-line-item", null, index.h("span", { slot: "description" }, wp.i18n.__('Discount', 'surecart')), index.h("sc-format-number", { slot: "price", style: {
                'font-weight': 'var(--sc-font-weight-semibold)',
                'color': 'var(--sc-color-gray-800)',
            }, type: "currency", currency: checkout === null || checkout === void 0 ? void 0 : checkout.currency, value: checkout === null || checkout === void 0 ? void 0 : checkout.discounts }))), !!((_f = (_e = checkout === null || checkout === void 0 ? void 0 : checkout.discount) === null || _e === void 0 ? void 0 : _e.promotion) === null || _f === void 0 ? void 0 : _f.code) && (index.h("sc-line-item", null, index.h("span", { slot: "description" }, wp.i18n.__('Discount', 'surecart'), index.h("br", null), index.h("sc-tag", { type: "success" }, wp.i18n.__('Coupon:', 'surecart'), " ", (_h = (_g = checkout === null || checkout === void 0 ? void 0 : checkout.discount) === null || _g === void 0 ? void 0 : _g.promotion) === null || _h === void 0 ? void 0 :
            _h.code)), index.h("sc-format-number", { slot: "price", style: {
                'font-weight': 'var(--sc-font-weight-semibold)',
                'color': 'var(--sc-color-gray-800)',
            }, type: "currency", currency: checkout === null || checkout === void 0 ? void 0 : checkout.currency, value: checkout === null || checkout === void 0 ? void 0 : checkout.discount_amount }))), !!(checkout === null || checkout === void 0 ? void 0 : checkout.shipping_amount) && (index.h("sc-line-item", null, index.h("span", { slot: "description" }, `${wp.i18n.__('Shipping', 'surecart')} ${shippingMethodName ? `(${shippingMethodName})` : ''}`), index.h("sc-format-number", { slot: "price", style: {
                'font-weight': 'var(--sc-font-weight-semibold)',
                'color': 'var(--sc-color-gray-800)',
            }, type: "currency", currency: checkout === null || checkout === void 0 ? void 0 : checkout.currency, value: checkout === null || checkout === void 0 ? void 0 : checkout.shipping_amount }))), !!(checkout === null || checkout === void 0 ? void 0 : checkout.tax_amount) && (index.h("sc-line-item", null, index.h("span", { slot: "description" }, tax.formatTaxDisplay(checkout === null || checkout === void 0 ? void 0 : checkout.tax_label), " (", checkout === null || checkout === void 0 ? void 0 :
            checkout.tax_percent, "%)"), index.h("sc-format-number", { slot: "price", style: {
                'font-weight': 'var(--sc-font-weight-semibold)',
                'color': 'var(--sc-color-gray-800)',
            }, type: "currency", currency: checkout === null || checkout === void 0 ? void 0 : checkout.currency, value: checkout === null || checkout === void 0 ? void 0 : checkout.tax_amount }))), index.h("sc-divider", { style: { '--spacing': 'var(--sc-spacing-x-small)' } }), index.h("sc-line-item", { style: {
                'width': '100%',
                '--price-size': 'var(--sc-font-size-x-large)',
            } }, index.h("span", { slot: "title" }, wp.i18n.__('Total', 'surecart')), index.h("span", { slot: "price" }, index.h("sc-format-number", { type: "currency", currency: checkout === null || checkout === void 0 ? void 0 : checkout.currency, value: checkout === null || checkout === void 0 ? void 0 : checkout.total_amount })), index.h("span", { slot: "currency" }, checkout === null || checkout === void 0 ? void 0 : checkout.currency)), (checkout === null || checkout === void 0 ? void 0 : checkout.amount_due) !== (checkout === null || checkout === void 0 ? void 0 : checkout.total_amount) && (index.h("sc-line-item", { style: {
                'width': '100%',
                '--price-size': 'var(--sc-font-size-x-large)',
            } }, index.h("span", { slot: "title" }, wp.i18n.__('Amount Due', 'surecart')), index.h("span", { slot: "price" }, index.h("sc-format-number", { type: "currency", currency: checkout === null || checkout === void 0 ? void 0 : checkout.currency, value: checkout === null || checkout === void 0 ? void 0 : checkout.amount_due })), index.h("span", { slot: "currency" }, checkout === null || checkout === void 0 ? void 0 : checkout.currency))), !!(checkout === null || checkout === void 0 ? void 0 : checkout.charge) && (index.h("sc-line-item", { style: {
                'width': '100%',
                '--price-size': 'var(--sc-font-size-x-large)',
            } }, index.h("span", { slot: "title" }, wp.i18n.__('Amount Paid', 'surecart')), index.h("span", { slot: "price" }, index.h("sc-format-number", { type: "currency", currency: (_j = checkout === null || checkout === void 0 ? void 0 : checkout.charge) === null || _j === void 0 ? void 0 : _j.currency, value: checkout === null || checkout === void 0 ? void 0 : checkout.paid_amount })), index.h("span", { slot: "currency" }, (_k = checkout === null || checkout === void 0 ? void 0 : checkout.charge) === null || _k === void 0 ? void 0 : _k.currency)))));
    }
    render() {
        var _a, _b, _c, _d, _e, _f, _g;
        const checkout = (_a = this === null || this === void 0 ? void 0 : this.order) === null || _a === void 0 ? void 0 : _a.checkout;
        const manualPaymentMethod = checkout === null || checkout === void 0 ? void 0 : checkout.manual_payment_method;
        return (index.h("sc-spacing", { key: '96e306d1eb2ce0fe5c52201585e376c1998a970a', style: { '--spacing': 'var(--sc-spacing-large)' } }, index.h("sc-dashboard-module", { key: '023fea7a09a8672c6038209b1583237a6ce56383', error: this.error }, index.h("span", { key: 'c9fbb16723bbe94861ebf1184b2d7c09b8f0e4cb', slot: "heading" }, this.loading ? index.h("sc-skeleton", { style: { width: '120px' } }) : `#${(_b = this === null || this === void 0 ? void 0 : this.order) === null || _b === void 0 ? void 0 : _b.number}`), !this.loading && !(checkout === null || checkout === void 0 ? void 0 : checkout.live_mode) && (index.h("sc-tag", { key: 'd7987b08a15db138a9fc6d2e80a904920c37d330', type: "warning", slot: "end" }, wp.i18n.__('Test Mode', 'surecart'))), !!(manualPaymentMethod === null || manualPaymentMethod === void 0 ? void 0 : manualPaymentMethod.name) && !!(manualPaymentMethod === null || manualPaymentMethod === void 0 ? void 0 : manualPaymentMethod.instructions) && (index.h("sc-order-manual-instructions", { key: 'a2ba7a0d0c02b6f12f47760975a383c1f08e3125', manualPaymentTitle: manualPaymentMethod === null || manualPaymentMethod === void 0 ? void 0 : manualPaymentMethod.name, manualPaymentInstructions: manualPaymentMethod === null || manualPaymentMethod === void 0 ? void 0 : manualPaymentMethod.instructions })), index.h("sc-card", { key: 'dd13dd5b6e1a324b151572f977eae9278959cd9c', "no-padding": !this.loading }, this.loading ? (this.renderLoading()) : (index.h(index.Fragment, null, index.h("sc-stacked-list", null, index.h("sc-stacked-list-row", { style: { '--columns': '2' } }, index.h("div", null, wp.i18n.__('Order Status', 'surecart')), index.h("sc-order-status-badge", { status: (_c = this === null || this === void 0 ? void 0 : this.order) === null || _c === void 0 ? void 0 : _c.status })), index.h("sc-stacked-list-row", { style: { '--columns': '2' } }, index.h("div", null, wp.i18n.__('Date', 'surecart')), index.h("sc-format-date", { type: "timestamp", date: (_d = this.order) === null || _d === void 0 ? void 0 : _d.created_at, month: "short", day: "numeric", year: "numeric" })), index.h("sc-stacked-list-row", { style: { '--columns': '2' } }, index.h("div", null, wp.i18n.__('Payment Method', 'surecart')), index.h("sc-payment-method", { paymentMethod: checkout === null || checkout === void 0 ? void 0 : checkout.payment_method })), index.h("div", { class: "order__row" }, this.renderContent())))))), ((_e = this.order) === null || _e === void 0 ? void 0 : _e.statement_url) && (index.h("sc-button", { key: 'ab79f61900e58ec4a151674d326aae2a412a9eba', type: "primary", href: (_f = this.order) === null || _f === void 0 ? void 0 : _f.statement_url, target: "_blank" }, index.h("sc-icon", { key: 'dc88a404af23708b6c0e847c9fffbca7746ef4f0', name: "inbox", slot: "prefix" }), wp.i18n.__('Download Receipt/Invoice', 'surecart'))), !!((_g = this.purchases) === null || _g === void 0 ? void 0 : _g.length) && index.h("sc-purchase-downloads-list", { key: 'c4b6d9d10c17437731789a69a9dcd0bbeb958fcc', heading: wp.i18n.__('Downloads', 'surecart'), purchases: this.purchases })));
    }
    get el() { return index.getElement(this); }
};
ScOrder.style = ScOrderStyle0;

exports.sc_order = ScOrder;

//# sourceMappingURL=sc-order.cjs.entry.js.map