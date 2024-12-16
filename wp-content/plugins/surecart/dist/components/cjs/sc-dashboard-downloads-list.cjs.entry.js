'use strict';

Object.defineProperty(exports, '__esModule', { value: true });

const index = require('./index-8acc3c89.js');
const fetch = require('./fetch-f25a0cb0.js');
const lazy = require('./lazy-2b509fa7.js');
const addQueryArgs = require('./add-query-args-49dcb630.js');
require('./remove-query-args-b57e8cd3.js');

const scDashboardDownloadsListCss = ":host{display:block}.download__details{opacity:0.75}";
const ScDashboardDownloadsListStyle0 = scDashboardDownloadsListCss;

const ScDownloadsList = class {
    constructor(hostRef) {
        index.registerInstance(this, hostRef);
        this.query = {
            page: 1,
            per_page: 10,
        };
        this.allLink = undefined;
        this.heading = undefined;
        this.isCustomer = undefined;
        this.requestNonce = undefined;
        this.purchases = [];
        this.loading = undefined;
        this.busy = undefined;
        this.error = undefined;
        this.pagination = {
            total: 0,
            total_pages: 0,
        };
    }
    componentWillLoad() {
        lazy.onFirstVisible(this.el, () => {
            this.initialFetch();
        });
    }
    async initialFetch() {
        if (!this.isCustomer) {
            return;
        }
        try {
            this.loading = true;
            await this.getItems();
        }
        catch (e) {
            console.error(this.error);
            this.error = (e === null || e === void 0 ? void 0 : e.message) || wp.i18n.__('Something went wrong', 'surecart');
        }
        finally {
            this.loading = false;
        }
    }
    async fetchItems() {
        if (!this.isCustomer) {
            return;
        }
        try {
            this.busy = true;
            await this.getItems();
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
    async getItems() {
        const response = (await await fetch.apiFetch({
            path: addQueryArgs.addQueryArgs(`surecart/v1/purchases/`, {
                expand: ['product', 'product.downloads', 'download.media'],
                downloadable: true,
                revoked: false,
                ...this.query,
            }),
            parse: false,
        }));
        this.pagination = {
            total: parseInt(response.headers.get('X-WP-Total')),
            total_pages: parseInt(response.headers.get('X-WP-TotalPages')),
        };
        this.purchases = (await response.json());
        return this.purchases;
    }
    nextPage() {
        this.query.page = this.query.page + 1;
        this.fetchItems();
    }
    prevPage() {
        this.query.page = this.query.page - 1;
        this.fetchItems();
    }
    render() {
        var _a;
        return (index.h("sc-purchase-downloads-list", { key: '81c0c9665a0039623b851a5b519cca34f5bdf81f', heading: this.heading, allLink: this.allLink && this.pagination.total_pages > 1 ? this.allLink : '', loading: this.loading, busy: this.busy, requestNonce: this.requestNonce, error: this.error, purchases: this.purchases }, index.h("span", { key: '9b295257cc9f6e060d3b433c6098524605a64634', slot: "heading" }, index.h("slot", { key: 'fee93edb49150167b7ba0fe808ceb4f24855a364', name: "heading" }, this.heading || wp.i18n.__('Downloads', 'surecart'))), index.h("sc-pagination", { key: '4e4c4577801b8bd242ea35a121fe120000a3ce62', slot: "after", page: this.query.page, perPage: this.query.per_page, total: this.pagination.total, totalPages: this.pagination.total_pages, totalShowing: (_a = this === null || this === void 0 ? void 0 : this.purchases) === null || _a === void 0 ? void 0 : _a.length, onScNextPage: () => this.nextPage(), onScPrevPage: () => this.prevPage() })));
    }
    get el() { return index.getElement(this); }
};
ScDownloadsList.style = ScDashboardDownloadsListStyle0;

exports.sc_dashboard_downloads_list = ScDownloadsList;

//# sourceMappingURL=sc-dashboard-downloads-list.cjs.entry.js.map