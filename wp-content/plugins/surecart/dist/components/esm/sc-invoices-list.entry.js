import { r as registerInstance, h, F as Fragment, a as getElement } from './index-745b6bec.js';
import { a as apiFetch } from './fetch-2032d11d.js';
import { o as onFirstVisible } from './lazy-deb42890.js';
import { a as addQueryArgs } from './add-query-args-0e2a8393.js';
import './remove-query-args-938c53ea.js';

const scInvoicesListCss = ":host{display:block}.orders-list{display:grid;gap:0.75em}.orders-list__heading{display:flex;flex-wrap:wrap;align-items:flex-end;justify-content:space-between}.orders-list__title{font-size:var(--sc-font-size-x-large);font-weight:var(--sc-font-weight-bold);line-height:var(--sc-line-height-dense)}.orders-list a{text-decoration:none;font-weight:var(--sc-font-weight-semibold);display:inline-flex;align-items:center;gap:0.25em;color:var(--sc-color-primary-500)}.order__row{color:var(--sc-color-gray-800);text-decoration:none;display:grid;align-items:center;justify-content:space-between;gap:0;grid-template-columns:1fr 1fr 1fr auto;margin:0;padding:var(--sc-spacing-small) var(--sc-spacing-large)}.order__row:not(:last-child){border-bottom:1px solid var(--sc-color-gray-200)}.order__row:hover{background:var(--sc-color-gray-50)}.order__date{font-weight:var(--sc-font-weight-semibold)}";
const ScInvoicesListStyle0 = scInvoicesListCss;

const ScInvoicesList = class {
    constructor(hostRef) {
        registerInstance(this, hostRef);
        this.query = {
            page: 1,
            per_page: 10,
        };
        this.allLink = undefined;
        this.heading = undefined;
        this.isCustomer = undefined;
        this.invoices = [];
        this.loading = undefined;
        this.busy = undefined;
        this.error = undefined;
        this.pagination = {
            total: 0,
            total_pages: 0,
        };
    }
    /** Only fetch if visible */
    componentWillLoad() {
        onFirstVisible(this.el, () => {
            this.initialFetch();
        });
    }
    async initialFetch() {
        try {
            this.loading = true;
            await this.getInvoices();
        }
        catch (e) {
            console.error(this.error);
            this.error = (e === null || e === void 0 ? void 0 : e.message) || wp.i18n.__('Something went wrong', 'surecart');
        }
        finally {
            this.loading = false;
        }
    }
    async fetchInvoices() {
        try {
            this.busy = true;
            await this.getInvoices();
        }
        catch (e) {
            console.error(this.error);
            this.error = (e === null || e === void 0 ? void 0 : e.message) || wp.i18n.__('Something went wrong', 'surecart');
        }
        finally {
            this.busy = false;
        }
    }
    /** Get all invoices */
    async getInvoices() {
        if (!this.isCustomer) {
            return;
        }
        const response = (await await apiFetch({
            path: addQueryArgs(`surecart/v1/invoices/`, {
                expand: ['checkout'],
                ...this.query,
            }),
            parse: false,
        }));
        this.pagination = {
            total: parseInt(response.headers.get('X-WP-Total')),
            total_pages: parseInt(response.headers.get('X-WP-TotalPages')),
        };
        this.invoices = (await response.json());
        return this.invoices;
    }
    nextPage() {
        this.query.page = this.query.page + 1;
        this.fetchInvoices();
    }
    prevPage() {
        this.query.page = this.query.page - 1;
        this.fetchInvoices();
    }
    renderLoading() {
        return (h("sc-card", { noPadding: true }, h("sc-stacked-list", null, h("sc-stacked-list-row", { style: { '--columns': '4' }, "mobile-size": 500 }, [...Array(4)].map(() => (h("sc-skeleton", { style: { width: '100px', display: 'inline-block' } })))))));
    }
    renderEmpty() {
        return (h("div", null, h("sc-divider", { style: { '--spacing': '0' } }), h("slot", { name: "empty" }, h("sc-empty", { icon: "shopping-bag" }, wp.i18n.__("You don't have any invoices.", 'surecart')))));
    }
    getInvoiceRedirectUrl(invoice) {
        var _a, _b, _c;
        // if it's open, redirect to checkout for payment.
        if (invoice.status === 'open') {
            return `${window.scData.pages.checkout}?checkout_id=${(_a = invoice === null || invoice === void 0 ? void 0 : invoice.checkout) === null || _a === void 0 ? void 0 : _a.id}`;
        }
        // else it's paid(as we're fetching only open/paid), redirect to order detail page.
        return addQueryArgs(window.location.href, {
            action: 'show',
            model: 'order',
            id: (_c = (_b = invoice === null || invoice === void 0 ? void 0 : invoice.checkout) === null || _b === void 0 ? void 0 : _b.order) === null || _c === void 0 ? void 0 : _c.id,
        });
    }
    renderList() {
        return this.invoices.map(invoice => {
            const { checkout } = invoice;
            if (!checkout)
                return null;
            const { amount_due, currency } = checkout;
            return (h("sc-stacked-list-row", { href: this.getInvoiceRedirectUrl(invoice), style: { '--columns': '4' }, "mobile-size": 500 }, h("div", null, "#", invoice === null || invoice === void 0 ? void 0 :
                invoice.order_number), h("div", null, (invoice === null || invoice === void 0 ? void 0 : invoice.due_date) ? (h(Fragment, null, wp.i18n.__('Due on', 'surecart'), " ", h("sc-format-date", { class: "invoice__date", date: (invoice === null || invoice === void 0 ? void 0 : invoice.due_date) * 1000, month: "short", day: "numeric", year: "numeric" }))) : ('—')), h("div", { class: "invoices-list__status" }, h("sc-invoice-status-badge", { status: invoice === null || invoice === void 0 ? void 0 : invoice.status })), h("div", null, h("sc-format-number", { type: "currency", currency: currency, value: amount_due }))));
        });
    }
    renderContent() {
        var _a;
        if (this.loading) {
            return this.renderLoading();
        }
        if (((_a = this.invoices) === null || _a === void 0 ? void 0 : _a.length) === 0) {
            return this.renderEmpty();
        }
        return (h("sc-card", { "no-padding": true }, h("sc-stacked-list", null, this.renderList())));
    }
    render() {
        var _a, _b;
        return (h("sc-dashboard-module", { key: 'c9065ab8c3a0b8164b4d49672a263bcf17809d71', class: "invoices-list", error: this.error }, h("span", { key: 'dc07097e8a6ee410f91a120cef4fb52179809a20', slot: "heading" }, h("slot", { key: 'd077dce5380318014e648f6431613ab325cdb1f9', name: "heading" }, this.heading || wp.i18n.__('Invoices', 'surecart'))), !!this.allLink && !!((_a = this.invoices) === null || _a === void 0 ? void 0 : _a.length) && (h("sc-button", { key: '452452fdf73a8a10af318e6d20450d7e430906d3', type: "link", href: this.allLink, slot: "end", "aria-label": wp.i18n.sprintf(wp.i18n.__('View all %s', 'surecart'), this.heading || wp.i18n.__('Invoices', 'surecart')) }, wp.i18n.__('View all', 'surecart'), h("sc-icon", { key: 'bbcfe2fa7db49139167d3c7b3edc72950c349d8c', "aria-hidden": "true", name: "chevron-right", slot: "suffix" }))), this.renderContent(), !this.allLink && (h("sc-pagination", { key: '5044b700c7970d468bbe18e4953def7fa021f726', page: this.query.page, perPage: this.query.per_page, total: this.pagination.total, totalPages: this.pagination.total_pages, totalShowing: (_b = this === null || this === void 0 ? void 0 : this.invoices) === null || _b === void 0 ? void 0 : _b.length, onScNextPage: () => this.nextPage(), onScPrevPage: () => this.prevPage() })), this.busy && h("sc-block-ui", { key: '926624b1b6a856fd299f0dc295b9529b4023e986' })));
    }
    get el() { return getElement(this); }
};
ScInvoicesList.style = ScInvoicesListStyle0;

export { ScInvoicesList as sc_invoices_list };

//# sourceMappingURL=sc-invoices-list.entry.js.map