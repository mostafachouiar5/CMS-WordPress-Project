'use strict';

Object.defineProperty(exports, '__esModule', { value: true });

const index = require('./index-8acc3c89.js');
const fetch = require('./fetch-f25a0cb0.js');
const lazy = require('./lazy-2b509fa7.js');
const addQueryArgs = require('./add-query-args-49dcb630.js');
require('./remove-query-args-b57e8cd3.js');

const scChargesListCss = ":host{display:block;position:relative}.charges-list{display:grid;gap:1em}";
const ScChargesListStyle0 = scChargesListCss;

const ScChargesList = class {
    constructor(hostRef) {
        index.registerInstance(this, hostRef);
        this.query = {
            page: 1,
            per_page: 10,
        };
        this.heading = undefined;
        this.showPagination = true;
        this.allLink = undefined;
        this.charges = [];
        this.loading = undefined;
        this.loaded = undefined;
        this.error = undefined;
        this.pagination = {
            total: 0,
            total_pages: 0,
        };
    }
    /** Only fetch if visible */
    componentWillLoad() {
        lazy.onFirstVisible(this.el, () => {
            this.getItems();
        });
    }
    /** Get items */
    async getItems() {
        try {
            this.loading = true;
            const response = (await fetch.apiFetch({
                path: addQueryArgs.addQueryArgs(`surecart/v1/charges/`, {
                    expand: ['checkout', 'checkout.order'],
                    ...this.query,
                }),
                parse: false,
            }));
            this.pagination = {
                total: parseInt(response.headers.get('X-WP-Total')),
                total_pages: parseInt(response.headers.get('X-WP-TotalPages')),
            };
            this.charges = (await response.json());
        }
        catch (e) {
            if (e === null || e === void 0 ? void 0 : e.message) {
                this.error = e.message;
            }
            else {
                this.error = wp.i18n.__('Something went wrong', 'surecart');
            }
            console.error(this.error);
        }
        finally {
            this.loading = false;
            this.loaded = true;
        }
    }
    renderRefundStatus(charge) {
        if (charge === null || charge === void 0 ? void 0 : charge.fully_refunded) {
            return index.h("sc-tag", { type: "danger" }, wp.i18n.__('Refunded', 'surecart'));
        }
        if (charge === null || charge === void 0 ? void 0 : charge.refunded_amount) {
            return index.h("sc-tag", { type: "warning" }, wp.i18n.__('Partially Refunded', 'surecart'));
        }
        return index.h("sc-tag", { type: "success" }, wp.i18n.__('Paid', 'surecart'));
    }
    renderEmpty() {
        return (index.h("sc-stacked-list-row", { "mobile-size": 0 }, index.h("slot", { name: "empty" }, wp.i18n.__('You have no saved payment methods.', 'surecart'))));
    }
    renderLoading() {
        return (index.h("sc-stacked-list-row", { style: { '--columns': '2' }, "mobile-size": 0 }, index.h("div", { style: { padding: '0.5em' } }, index.h("sc-skeleton", { style: { width: '30%', marginBottom: '0.75em' } }), index.h("sc-skeleton", { style: { width: '20%', marginBottom: '0.75em' } }), index.h("sc-skeleton", { style: { width: '40%' } }))));
    }
    renderContent() {
        var _a;
        if (this.loading && !this.loaded) {
            return this.renderLoading();
        }
        if (((_a = this.charges) === null || _a === void 0 ? void 0 : _a.length) === 0) {
            return this.renderEmpty();
        }
        return this.charges.map(charge => {
            var _a;
            const { currency, amount, created_at } = charge;
            return (index.h("sc-stacked-list-row", { style: { '--columns': '4' }, "mobile-size": 600, href: addQueryArgs.addQueryArgs(window.location.href, {
                    action: 'show',
                    model: 'order',
                    id: (_a = charge.checkout.order) === null || _a === void 0 ? void 0 : _a.id,
                }) }, index.h("strong", null, index.h("sc-format-date", { date: created_at, type: "timestamp", month: "short", day: "numeric", year: "numeric" })), index.h("sc-text", { style: { '--color': 'var(--sc-color-gray-500)' } }, wp.i18n.sprintf(wp.i18n.__('#%s', 'surecart'), charge.checkout.order.number)), index.h("div", null, this.renderRefundStatus(charge)), index.h("strong", null, index.h("sc-format-number", { type: "currency", value: amount, currency: currency }))));
        });
    }
    nextPage() {
        this.query.page = this.query.page + 1;
        this.getItems();
    }
    prevPage() {
        this.query.page = this.query.page - 1;
        this.getItems();
    }
    render() {
        var _a;
        return (index.h("sc-dashboard-module", { key: '3536b6533dd11a1357c5ddb62df6851bcfeba518', class: "charges-list", error: this.error }, index.h("span", { key: '5361aed5f8fe0266586f0e0dd0b0a6d789b2ec66', slot: "heading" }, index.h("slot", { key: '2cac45865795138c4e160276d93d6a98eff3e1c0', name: "heading" }, this.heading || wp.i18n.__('Payment History', 'surecart'))), !!this.allLink && (index.h("sc-button", { key: '2e8f6ed1949eb7f96936d85f243106174455e893', type: "link", href: this.allLink, slot: "end" }, wp.i18n.__('View all', 'surecart'), index.h("sc-icon", { key: '29ff870d607af973fe665cfaacd365e722eda0de', name: "chevron-right", slot: "suffix" }))), index.h("sc-card", { key: 'b0561cb68a2cb875133b20702b4d782cef8fe910', "no-padding": true, style: { '--overflow': 'hidden' } }, index.h("sc-stacked-list", { key: '2621f0b9c97a0453509695f750fad09e4d6fc254' }, this.renderContent())), this.showPagination && (index.h("sc-pagination", { key: 'de77c0da048e6945ec401bdf7d22b25a4df48f34', page: this.query.page, perPage: this.query.per_page, total: this.pagination.total, totalPages: this.pagination.total_pages, totalShowing: (_a = this === null || this === void 0 ? void 0 : this.charges) === null || _a === void 0 ? void 0 : _a.length, onScNextPage: () => this.nextPage(), onScPrevPage: () => this.prevPage() })), this.loading && this.loaded && index.h("sc-block-ui", { key: 'd990b9fe064915fa855bce2e50ce8b2e582dffef', spinner: true })));
    }
    get el() { return index.getElement(this); }
};
ScChargesList.style = ScChargesListStyle0;

exports.sc_charges_list = ScChargesList;

//# sourceMappingURL=sc-charges-list.cjs.entry.js.map