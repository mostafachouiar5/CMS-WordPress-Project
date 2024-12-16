import { r as registerInstance, h, a as getElement } from './index-745b6bec.js';
import { a as apiFetch } from './fetch-2032d11d.js';
import { o as onFirstVisible } from './lazy-deb42890.js';
import { a as addQueryArgs } from './add-query-args-0e2a8393.js';
import './remove-query-args-938c53ea.js';

const scSubscriptionsListCss = ":host{display:block}.subscriptions-list{display:grid;gap:0.5em}.subscriptions-list__heading{display:flex;flex-wrap:wrap;align-items:flex-end;justify-content:space-between;margin-bottom:0.5em}.subscriptions-list__title{font-size:var(--sc-font-size-x-large);font-weight:var(--sc-font-weight-bold);line-height:var(--sc-line-height-dense)}.subscriptions-list a{text-decoration:none;font-weight:var(--sc-font-weight-semibold);display:inline-flex;align-items:center;gap:0.25em;color:var(--sc-color-primary-500)}.subscriptions__title{display:none}.subscriptions--has-title-slot .subscriptions__title{display:block}";
const ScSubscriptionsListStyle0 = scSubscriptionsListCss;

const ScSubscriptionsList = class {
    constructor(hostRef) {
        registerInstance(this, hostRef);
        this.query = {
            page: 1,
            per_page: 10,
        };
        this.allLink = undefined;
        this.heading = undefined;
        this.isCustomer = undefined;
        this.cancelBehavior = 'period_end';
        this.subscriptions = [];
        this.loading = undefined;
        this.busy = undefined;
        this.error = undefined;
        this.pagination = {
            total: 0,
            total_pages: 0,
        };
    }
    componentWillLoad() {
        onFirstVisible(this.el, () => {
            this.initialFetch();
        });
    }
    async initialFetch() {
        try {
            this.loading = true;
            await this.getSubscriptions();
        }
        catch (e) {
            console.error(this.error);
            this.error = (e === null || e === void 0 ? void 0 : e.message) || wp.i18n.__('Something went wrong', 'surecart');
        }
        finally {
            this.loading = false;
        }
    }
    async fetchSubscriptions() {
        try {
            this.busy = true;
            await this.getSubscriptions();
        }
        catch (e) {
            console.error(this.error);
            this.error = (e === null || e === void 0 ? void 0 : e.message) || wp.i18n.__('Something went wrong', 'surecart');
        }
        finally {
            this.busy = false;
        }
    }
    /** Get all subscriptions */
    async getSubscriptions() {
        if (!this.isCustomer) {
            return;
        }
        const response = (await await apiFetch({
            path: addQueryArgs(`surecart/v1/subscriptions/`, {
                expand: ['price', 'price.product', 'current_period', 'period.checkout', 'purchase', 'purchase.license', 'license.activations', 'discount', 'discount.coupon'],
                ...this.query,
            }),
            parse: false,
        }));
        this.pagination = {
            total: parseInt(response.headers.get('X-WP-Total')),
            total_pages: parseInt(response.headers.get('X-WP-TotalPages')),
        };
        this.subscriptions = (await response.json());
        return this.subscriptions;
    }
    nextPage() {
        this.query.page = this.query.page + 1;
        this.fetchSubscriptions();
    }
    prevPage() {
        this.query.page = this.query.page - 1;
        this.fetchSubscriptions();
    }
    renderEmpty() {
        return (h("div", null, h("sc-divider", { style: { '--spacing': '0' } }), h("slot", { name: "empty" }, h("sc-empty", { icon: "repeat" }, wp.i18n.__("You don't have any subscriptions.", 'surecart')))));
    }
    renderLoading() {
        return (h("sc-card", { "no-padding": true, style: { '--overflow': 'hidden' } }, h("sc-stacked-list", null, h("sc-stacked-list-row", { style: { '--columns': '2' }, "mobile-size": 0 }, h("div", { style: { padding: '0.5em' } }, h("sc-skeleton", { style: { width: '30%', marginBottom: '0.75em' } }), h("sc-skeleton", { style: { width: '20%', marginBottom: '0.75em' } }), h("sc-skeleton", { style: { width: '40%' } }))))));
    }
    getSubscriptionLink(subscription) {
        return addQueryArgs(window.location.href, {
            action: 'edit',
            model: 'subscription',
            id: subscription.id,
        });
    }
    renderList() {
        return this.subscriptions.map(subscription => {
            return (h("sc-stacked-list-row", { href: this.getSubscriptionLink(subscription), key: subscription.id, "mobile-size": 0 }, h("sc-subscription-details", { subscription: subscription }), h("sc-icon", { name: "chevron-right", slot: "suffix" })));
        });
    }
    renderContent() {
        var _a;
        if (this.loading) {
            return this.renderLoading();
        }
        if (((_a = this.subscriptions) === null || _a === void 0 ? void 0 : _a.length) === 0) {
            return this.renderEmpty();
        }
        return (h("sc-card", { "no-padding": true, style: { '--overflow': 'hidden' } }, h("sc-stacked-list", null, this.renderList())));
    }
    render() {
        var _a, _b;
        return (h("sc-dashboard-module", { key: '94410649ba1138510c9be20d8aba6d86cb6c9ce6', class: "subscriptions-list", error: this.error }, h("span", { key: 'b2cb86c42b398b70c675c2bd8e3d32929f116b2d', slot: "heading" }, h("slot", { key: '904419d351e4ec7304697fbb1e9dd95ac05a7bdb', name: "heading" }, this.heading || wp.i18n.__('Subscriptions', 'surecart'))), !!this.allLink && !!((_a = this.subscriptions) === null || _a === void 0 ? void 0 : _a.length) && (h("sc-button", { key: '637cec9d3af368b53369b6bcbfe31744b624e00f', type: "link", href: this.allLink, slot: "end", "aria-label": wp.i18n.sprintf(wp.i18n.__('View all %s', 'surecart'), this.heading || 'Subscriptions') }, wp.i18n.__('View all', 'surecart'), h("sc-icon", { key: '529bb83393af8aa05ea58f921f978c9534a5cc9a', "aria-hidden": "true", name: "chevron-right", slot: "suffix" }))), this.renderContent(), !this.allLink && (h("sc-pagination", { key: '2e0dd6372ab15693511f0bcee42d35e04bf69307', page: this.query.page, perPage: this.query.per_page, total: this.pagination.total, totalPages: this.pagination.total_pages, totalShowing: (_b = this === null || this === void 0 ? void 0 : this.subscriptions) === null || _b === void 0 ? void 0 : _b.length, onScNextPage: () => this.nextPage(), onScPrevPage: () => this.prevPage() })), this.busy && h("sc-block-ui", { key: '0a5b2f433fe9b76fd3a25c8d86c7d6676cb997af' })));
    }
    get el() { return getElement(this); }
};
ScSubscriptionsList.style = ScSubscriptionsListStyle0;

export { ScSubscriptionsList as sc_subscriptions_list };

//# sourceMappingURL=sc-subscriptions-list.entry.js.map