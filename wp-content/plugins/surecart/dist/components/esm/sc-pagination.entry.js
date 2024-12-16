import { r as registerInstance, c as createEvent, h } from './index-745b6bec.js';

const scPaginationCss = ":host{display:block}.pagination-display{opacity:0.8}";
const ScPaginationStyle0 = scPaginationCss;

const ScPagination = class {
    constructor(hostRef) {
        registerInstance(this, hostRef);
        this.scPrevPage = createEvent(this, "scPrevPage", 7);
        this.scNextPage = createEvent(this, "scNextPage", 7);
        this.page = 1;
        this.perPage = 0;
        this.total = 0;
        this.totalShowing = 0;
        this.totalPages = 0;
        this.hasNextPage = undefined;
        this.hasPreviousPage = undefined;
        this.from = undefined;
        this.to = undefined;
    }
    componentWillLoad() {
        this.handlePaginationChange();
    }
    handlePaginationChange() {
        // do we have a previous or next page?
        this.hasNextPage = this.total > 1 && this.page < this.totalPages;
        this.hasPreviousPage = this.totalPages > 1 && this.page > 1;
        // from->to.
        this.from = this.perPage * (this.page - 1) + 1;
        this.to = Math.min(this.from + this.totalShowing - 1, this.total);
    }
    render() {
        if (!this.hasNextPage && !this.hasPreviousPage)
            return null;
        return (h("sc-flex", null, h("div", { class: "pagination-display" }, wp.i18n.sprintf(wp.i18n.__('Displaying %1d to %2d of %3d items', 'surecart'), this.from, this.to, this.total)), h("sc-flex", null, h("sc-button", { onClick: () => this.scPrevPage.emit(), type: "text", disabled: !this.hasPreviousPage }, h("sc-visually-hidden", null, wp.i18n.__('Display previous page of items', 'surecart')), h("span", { "aria-hidden": "true" }, wp.i18n.__('Previous', 'surecart')), h("sc-icon", { "aria-hidden": "true", name: "arrow-left", slot: "prefix" })), h("sc-button", { onClick: () => this.scNextPage.emit(), type: "text", disabled: !this.hasNextPage }, h("sc-visually-hidden", null, wp.i18n.__('Display next page of items', 'surecart')), h("span", { "aria-hidden": "true" }, wp.i18n.__('Next', 'surecart')), h("sc-icon", { "aria-hidden": "true", name: "arrow-right", slot: "suffix" })))));
    }
    static get watchers() { return {
        "total": ["handlePaginationChange"],
        "totalPages": ["handlePaginationChange"],
        "page": ["handlePaginationChange"],
        "perPage": ["handlePaginationChange"],
        "totalShowing": ["handlePaginationChange"]
    }; }
};
ScPagination.style = ScPaginationStyle0;

export { ScPagination as sc_pagination };

//# sourceMappingURL=sc-pagination.entry.js.map