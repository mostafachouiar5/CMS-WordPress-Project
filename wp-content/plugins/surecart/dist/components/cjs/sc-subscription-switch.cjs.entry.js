'use strict';

Object.defineProperty(exports, '__esModule', { value: true });

const index = require('./index-8acc3c89.js');
const fetch = require('./fetch-f25a0cb0.js');
const lazy = require('./lazy-2b509fa7.js');
const price = require('./price-653ec1cb.js');
const addQueryArgs = require('./add-query-args-49dcb630.js');
require('./remove-query-args-b57e8cd3.js');
require('./currency-71fce0f0.js');

const scSubscriptionSwitchCss = ":host{display:block;position:relative}[hidden]{display:none !important}.subscriptions-switch{display:grid;gap:0.5em}.subscriptions-switch__switcher{background:rgba(0, 0, 0, 0.035);padding:2px;line-height:1;border-radius:var(--sc-border-radius-small)}";
const ScSubscriptionSwitchStyle0 = scSubscriptionSwitchCss;

const ScSubscriptionSwitch = class {
    constructor(hostRef) {
        index.registerInstance(this, hostRef);
        this.query = undefined;
        this.heading = undefined;
        this.productGroupId = undefined;
        this.productId = undefined;
        this.subscription = undefined;
        this.filterAbove = 4;
        this.successUrl = window.location.href;
        this.selectedPrice = undefined;
        this.products = [];
        this.prices = undefined;
        this.filter = 'month';
        this.hasFilters = undefined;
        this.showFilters = undefined;
        this.loading = undefined;
        this.busy = undefined;
        this.error = undefined;
    }
    componentWillLoad() {
        lazy.onFirstVisible(this.el, async () => {
            try {
                this.loading = true;
                await Promise.all([this.getGroup(), this.getProductPrices()]);
            }
            catch (e) {
                console.error(e);
                if (e === null || e === void 0 ? void 0 : e.message) {
                    this.error = e.message;
                }
                else {
                    this.error = wp.i18n.__('Something went wrong', 'surecart');
                }
            }
            finally {
                this.loading = false;
            }
        });
        this.handleSubscriptionChange();
    }
    handleProductsChange() {
        var _a;
        this.prices = this.products
            .map(product => { var _a; return (_a = product === null || product === void 0 ? void 0 : product.prices) === null || _a === void 0 ? void 0 : _a.data; })
            .flat()
            .filter((v, i, a) => a.findIndex(t => t.id === v.id) === i) // remove duplicates.
            .filter(price => !(price === null || price === void 0 ? void 0 : price.archived)) // remove archived
            .filter(price => price.portal_subscription_update_enabled); // only show prices that can be upgraded to.
        this.showFilters = ((_a = this.prices) === null || _a === void 0 ? void 0 : _a.length) > this.filterAbove;
    }
    handlePricesChange(val, prev) {
        if (!(prev === null || prev === void 0 ? void 0 : prev.length) && (val === null || val === void 0 ? void 0 : val.length)) {
            this.selectedPrice = val.find(price => { var _a, _b; return price.id === ((_b = (_a = this.subscription) === null || _a === void 0 ? void 0 : _a.price) === null || _b === void 0 ? void 0 : _b.id); });
        }
        this.hasFilters = {
            ...this.hasFilters,
            split: this.prices.some(price => !!(price === null || price === void 0 ? void 0 : price.recurring_period_count) && !(price === null || price === void 0 ? void 0 : price.archived)),
            month: this.prices.some(price => price.recurring_interval === 'month' && !(price === null || price === void 0 ? void 0 : price.recurring_period_count) && !(price === null || price === void 0 ? void 0 : price.archived)),
            year: this.prices.some(price => price.recurring_interval === 'year' && !(price === null || price === void 0 ? void 0 : price.recurring_period_count) && !(price === null || price === void 0 ? void 0 : price.archived)),
            never: this.prices.some(price => (price.recurring_interval === 'never' || !price.recurring_interval) && !(price === null || price === void 0 ? void 0 : price.archived)),
        };
    }
    handleSubscriptionChange() {
        var _a, _b;
        this.filter = ((_b = (_a = this.subscription) === null || _a === void 0 ? void 0 : _a.price) === null || _b === void 0 ? void 0 : _b.recurring_interval) || 'month';
    }
    hasMultipleFilters() {
        return Object.values(this.hasFilters || {}).filter(v => !!v).length > 1;
    }
    /** Get all subscriptions */
    async getGroup() {
        if (!this.productGroupId)
            return;
        const products = (await await fetch.apiFetch({
            path: addQueryArgs.addQueryArgs(`surecart/v1/products/`, {
                product_group_ids: [this.productGroupId],
                expand: ['prices'],
                ...this.query,
            }),
        }));
        this.products = [...this.products, ...products];
    }
    /** Get the product's prices. */
    async getProductPrices() {
        if (!this.productId)
            return;
        const product = (await await fetch.apiFetch({
            path: addQueryArgs.addQueryArgs(`surecart/v1/products/${this.productId}`, {
                expand: ['prices'],
            }),
        }));
        this.products = [...this.products, ...[product]];
    }
    async handleSubmit(e) {
        var _a, _b, _c, _d, _e, _f, _g, _h;
        const { plan } = await e.target.getFormJson();
        const price = this.prices.find(p => p.id === plan);
        const currentPlan = (_a = this.subscription) === null || _a === void 0 ? void 0 : _a.price;
        if ((price === null || price === void 0 ? void 0 : price.id) === currentPlan.id && !(price === null || price === void 0 ? void 0 : price.ad_hoc) && !((_c = (_b = this.subscription) === null || _b === void 0 ? void 0 : _b.variant_options) === null || _c === void 0 ? void 0 : _c.length))
            return;
        // confirm product variation.
        if ((_e = (_d = this.subscription) === null || _d === void 0 ? void 0 : _d.variant_options) === null || _e === void 0 ? void 0 : _e.length) {
            this.busy = true;
            return window.location.assign(addQueryArgs.addQueryArgs(this.successUrl, {
                action: 'confirm_variation',
                price_id: plan,
                ...(((_f = this.subscription) === null || _f === void 0 ? void 0 : _f.live_mode) === false ? { live_mode: false } : {}),
            }));
        }
        // confirm ad_hoc amount.
        if (price === null || price === void 0 ? void 0 : price.ad_hoc) {
            this.busy = true;
            return window.location.assign(addQueryArgs.addQueryArgs(this.successUrl, {
                action: 'confirm_amount',
                price_id: plan,
                ...(((_g = this.subscription) === null || _g === void 0 ? void 0 : _g.live_mode) === false ? { live_mode: false } : {}),
            }));
        }
        // confirm plan.
        this.busy = true;
        window.location.assign(addQueryArgs.addQueryArgs(this.successUrl, {
            action: 'confirm',
            price_id: plan,
            ...(((_h = this.subscription) === null || _h === void 0 ? void 0 : _h.live_mode) === false ? { live_mode: false } : {}),
        }));
    }
    renderSwitcher() {
        if (!this.hasMultipleFilters())
            return;
        if (!this.showFilters)
            return;
        return (index.h("sc-flex", { slot: "end", class: "subscriptions-switch__switcher" }, this.hasFilters.month && (index.h("sc-button", { onClick: () => (this.filter = 'month'), size: "small", type: this.filter === 'month' ? 'default' : 'text' }, wp.i18n.__('Monthly', 'surecart'))), this.hasFilters.week && (index.h("sc-button", { onClick: () => (this.filter = 'week'), size: "small", type: this.filter === 'week' ? 'default' : 'text' }, wp.i18n.__('Weekly', 'surecart'))), this.hasFilters.year && (index.h("sc-button", { onClick: () => (this.filter = 'year'), size: "small", type: this.filter === 'year' ? 'default' : 'text' }, wp.i18n.__('Yearly', 'surecart'))), this.hasFilters.never && (index.h("sc-button", { onClick: () => (this.filter = 'never'), size: "small", type: this.filter === 'never' ? 'default' : 'text' }, wp.i18n.__('Lifetime', 'surecart'))), this.hasFilters.split && (index.h("sc-button", { onClick: () => (this.filter = 'split'), size: "small", type: this.filter === 'split' ? 'default' : 'text' }, wp.i18n.__('Payment Plan', 'surecart')))));
    }
    renderLoading() {
        return (index.h("sc-choice", { name: "loading", disabled: true }, index.h("sc-skeleton", { style: { width: '60px', display: 'inline-block' } }), index.h("sc-skeleton", { style: { width: '80px', display: 'inline-block' }, slot: "price" }), index.h("sc-skeleton", { style: { width: '120px', display: 'inline-block' }, slot: "description" })));
    }
    /** Is the price hidden or not */
    isHidden(price) {
        // don't hide if no filters or has no multiple filters available.
        if (!this.showFilters || !this.hasMultipleFilters())
            return false;
        // hide if the filter does not match the recurring interval.
        let hidden = this.filter !== price.recurring_interval;
        // if filter is never, show prices with non-recurring interval.
        if (this.filter === 'never' && !(price === null || price === void 0 ? void 0 : price.recurring_interval)) {
            hidden = false;
        }
        // if filter is split, show prices with a recurring_period_count.
        if (this.filter === 'split' && (price === null || price === void 0 ? void 0 : price.recurring_period_count)) {
            hidden = false;
        }
        return hidden;
    }
    renderContent() {
        if (this.loading) {
            return this.renderLoading();
        }
        return (index.h("sc-choices", { required: true }, index.h("div", null, (this.prices || [])
            .filter(price => !price.archived)
            .filter(price => { var _a; return (price === null || price === void 0 ? void 0 : price.currency) === ((_a = this.subscription) === null || _a === void 0 ? void 0 : _a.currency); })
            .sort((a, b) => a.amount - b.amount)
            .map(price$1 => {
            var _a, _b;
            const currentPlan = ((_b = (_a = this.subscription) === null || _a === void 0 ? void 0 : _a.price) === null || _b === void 0 ? void 0 : _b.id) === (price$1 === null || price$1 === void 0 ? void 0 : price$1.id);
            const product = this.products.find(product => product.id === (price$1 === null || price$1 === void 0 ? void 0 : price$1.product));
            return (index.h("sc-choice", { key: price$1 === null || price$1 === void 0 ? void 0 : price$1.id, checked: currentPlan, name: "plan", value: price$1 === null || price$1 === void 0 ? void 0 : price$1.id, hidden: this.isHidden(price$1), onScChange: e => {
                    if (e.detail) {
                        this.selectedPrice = this.prices.find(p => p.id === (price$1 === null || price$1 === void 0 ? void 0 : price$1.id));
                    }
                } }, index.h("div", null, index.h("strong", null, product === null || product === void 0 ? void 0 :
                product.name, " ", (price$1 === null || price$1 === void 0 ? void 0 : price$1.name) && index.h(index.Fragment, null, " \u2014 ", price$1 === null || price$1 === void 0 ? void 0 :
                price$1.name))), index.h("div", { slot: "description" }, (price$1 === null || price$1 === void 0 ? void 0 : price$1.ad_hoc) ? (`${wp.i18n.__('Custom amount', 'surecart')} ${price.intervalString(price$1)}`) : (index.h(index.Fragment, null, index.h("sc-format-number", { type: "currency", currency: (price$1 === null || price$1 === void 0 ? void 0 : price$1.currency) || 'usd', value: price$1 === null || price$1 === void 0 ? void 0 : price$1.amount }), " ", price.intervalString(price$1, { showOnce: true })))), currentPlan && (index.h("sc-tag", { type: "warning", slot: "price" }, wp.i18n.__('Current Plan', 'surecart')))));
        }))));
    }
    buttonText() {
        var _a, _b, _c, _d, _e, _f, _g, _h, _j;
        if ((_b = (_a = this.subscription) === null || _a === void 0 ? void 0 : _a.variant_options) === null || _b === void 0 ? void 0 : _b.length) {
            if (((_c = this.selectedPrice) === null || _c === void 0 ? void 0 : _c.id) === ((_e = (_d = this.subscription) === null || _d === void 0 ? void 0 : _d.price) === null || _e === void 0 ? void 0 : _e.id)) {
                return wp.i18n.__('Update Options', 'surecart');
            }
            else {
                return wp.i18n.__('Choose Options', 'surecart');
            }
        }
        if ((_f = this.selectedPrice) === null || _f === void 0 ? void 0 : _f.ad_hoc) {
            if (((_g = this.selectedPrice) === null || _g === void 0 ? void 0 : _g.id) === ((_j = (_h = this.subscription) === null || _h === void 0 ? void 0 : _h.price) === null || _j === void 0 ? void 0 : _j.id)) {
                return wp.i18n.__('Update Amount', 'surecart');
            }
            else {
                return wp.i18n.__('Choose Amount', 'surecart');
            }
        }
        return wp.i18n.__('Next', 'surecart');
    }
    buttonDisabled() {
        var _a, _b, _c, _d, _e;
        if ((_a = this.subscription) === null || _a === void 0 ? void 0 : _a.variant_options) {
            return false;
        }
        return ((_c = (_b = this.subscription) === null || _b === void 0 ? void 0 : _b.price) === null || _c === void 0 ? void 0 : _c.id) === ((_d = this.selectedPrice) === null || _d === void 0 ? void 0 : _d.id) && !((_e = this.selectedPrice) === null || _e === void 0 ? void 0 : _e.ad_hoc);
    }
    render() {
        var _a, _b, _c, _d, _e, _f;
        // we are not loading and we don't have enough prices to switch.
        if (!this.loading && ((_a = this.prices) === null || _a === void 0 ? void 0 : _a.length) < 2) {
            if (!((_c = (_b = this.prices) === null || _b === void 0 ? void 0 : _b[0]) === null || _c === void 0 ? void 0 : _c.ad_hoc) && !((_e = (_d = this.subscription) === null || _d === void 0 ? void 0 : _d.variant_options) === null || _e === void 0 ? void 0 : _e.length)) {
                return null;
            }
        }
        // subscription is a payment plan.
        if ((_f = this.subscription) === null || _f === void 0 ? void 0 : _f.finite) {
            return (index.h("sc-alert", { type: "info", open: true }, wp.i18n.__('To make changes to your payment plan, please contact us.', 'surecart')));
        }
        return (index.h("sc-dashboard-module", { heading: this.heading || wp.i18n.__('Update Plan', 'surecart'), class: "subscription-switch", error: this.error }, index.h("span", { slot: "end" }, this.renderSwitcher()), index.h("sc-form", { class: "subscriptions-switch", onScFormSubmit: e => this.handleSubmit(e) }, this.renderContent(), index.h("sc-button", { type: "primary", full: true, submit: true, loading: this.loading || this.busy, disabled: this.buttonDisabled() }, this.buttonText(), " ", index.h("sc-icon", { name: "arrow-right", slot: "suffix" })), this.busy && index.h("sc-block-ui", { style: { zIndex: '9' } }))));
    }
    get el() { return index.getElement(this); }
    static get watchers() { return {
        "products": ["handleProductsChange"],
        "prices": ["handlePricesChange"],
        "subscription": ["handleSubscriptionChange"]
    }; }
};
ScSubscriptionSwitch.style = ScSubscriptionSwitchStyle0;

exports.sc_subscription_switch = ScSubscriptionSwitch;

//# sourceMappingURL=sc-subscription-switch.cjs.entry.js.map