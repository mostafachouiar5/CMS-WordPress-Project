import { r as registerInstance, c as createEvent, h, a as getElement } from './index-745b6bec.js';
import { s as speak } from './index-c5a96d53.js';
import { a as apiFetch, h as handleNonceError } from './fetch-2032d11d.js';
import './google-dd89f242.js';
import { a as addQueryArgs, g as getQueryArgs } from './add-query-args-0e2a8393.js';
import './remove-query-args-938c53ea.js';
import './currency-a0c9bff4.js';
import './google-a86aa761.js';

const scProductItemListCss = ":host {\n  display: block;\n}\n\n.product-item-list {\n  display: grid;\n  grid-template-columns: repeat(var(--sc-product-item-list-column), 1fr);\n  gap: var(--sc-product-item-list-gap);\n}\n.product-item-list__wrapper {\n  container-type: inline-size;\n  display: grid;\n  gap: var(--sc-spacing-medium);\n}\n@container (max-width: 576px) {\n  .product-item-list__wrapper .product-item-list {\n    grid-template-columns: 1fr;\n  }\n}\n@container (min-width: 576px) and (max-width: 768px) {\n  .product-item-list__wrapper .product-item-list {\n    grid-template-columns: repeat(3, 1fr);\n  }\n}\n.product-item-list__sort, .product-item-list__empty, .product-item-list__search, .product-item-list__search-tag {\n  font-size: 16px;\n}\n.product-item-list__search, .product-item-list__sort {\n  display: flex;\n  align-items: center;\n  gap: var(--sc-spacing-small);\n}\n.product-item-list__controls {\n  display: flex;\n  flex-wrap: wrap;\n  justify-content: space-between;\n  align-items: center;\n}\n.product-item-list__loader {\n  display: grid;\n  gap: 0.88rem;\n  padding-top: var(--sc-product-item-padding-top);\n  padding-bottom: var(--sc-product-item-padding-bottom);\n  padding-left: var(--sc-product-item-padding-left);\n  padding-right: var(--sc-product-item-padding-right);\n  margin-top: var(--sc-product-item-margin-top);\n  margin-bottom: var(--sc-product-item-margin-bottom);\n  margin-left: var(--sc-product-item-margin-left);\n  margin-right: var(--sc-product-item-margin-right);\n  border: solid var(--sc-product-item-border-width) var(--sc-product-item-border-color);\n  border-radius: var(--sc-product-item-border-radius);\n  color: var(--sc-product-title-text-color);\n  background-color: var(--sc-product-item-background-color);\n  line-height: 1;\n}\n.product-item-list__pagination {\n  padding: 40px 0 0;\n  width: 100%;\n  font-size: var(--sc-font-size-small, var(--wp--preset--font-size--x-small));\n}\n.product-item-list__search-tag {\n  display: flex;\n  align-items: center;\n  flex-wrap: wrap;\n  gap: var(--sc-spacing-small);\n}\n.product-item-list__search-label {\n  font-size: var(--sc-font-size-small, var(--wp--preset--font-size--x-small));\n}\n\n.search-button,\n.clear-button {\n  opacity: 0;\n  visibility: hidden;\n  transition: opacity var(--sc-transition-medium) ease-in-out;\n  cursor: pointer;\n}\n\n.product-item-list__has-search .search-button,\n.product-item-list__has-search .clear-button {\n  opacity: 1;\n  visibility: visible;\n}\n\nsc-product-item::part(image) {\n  aspect-ratio: var(--sc-product-image-aspect-ratio);\n}\n\nsc-dropdown sc-button::part(base):focus-visible {\n  border: 1px dashed var(--sc-product-item-border-color, --sc-color-gray-50);\n}\n\nsc-pagination {\n  font-size: var(--sc-pagination-font-size);\n}";
const ScProductItemListStyle0 = scProductItemListCss;

const ScProductItemList = class {
    constructor(hostRef) {
        registerInstance(this, hostRef);
        this.scSearched = createEvent(this, "scSearched", 7);
        this.scProductsViewed = createEvent(this, "scProductsViewed", 7);
        this.ids = undefined;
        this.sort = 'created_at:desc';
        this.query = undefined;
        this.searchEnabled = true;
        this.sortEnabled = true;
        this.collectionEnabled = true;
        this.collectionId = undefined;
        this.pageTitle = undefined;
        this.featured = false;
        this.paginationEnabled = true;
        this.ajaxPagination = true;
        this.paginationAutoScroll = true;
        this.layoutConfig = undefined;
        this.paginationAlignment = 'center';
        this.limit = 15;
        this.page = 1;
        this.products = undefined;
        this.loading = false;
        this.busy = false;
        this.error = undefined;
        this.currentPage = 1;
        this.currentQuery = undefined;
        this.pagination = {
            total: 0,
            total_pages: 0,
        };
        this.collections = undefined;
        this.selectedCollections = [];
    }
    handleProductsChanged(newProducts, oldProducts) {
        var _a;
        const productIds = new Set([...(oldProducts || []).map(product => product.id), ...(newProducts || []).map(product => product.id)]);
        if ((newProducts === null || newProducts === void 0 ? void 0 : newProducts.length) === (oldProducts === null || oldProducts === void 0 ? void 0 : oldProducts.length) && productIds.size === newProducts.length) {
            return;
        }
        const title = [
            this.pageTitle,
            this.paginationEnabled ? wp.i18n.sprintf(wp.i18n.__('Page %d', 'surecart'), this.currentPage) : undefined,
            this.sort ? this.renderSortName() : undefined,
            this.query || ((_a = this.selectedCollections) === null || _a === void 0 ? void 0 : _a.length) ? wp.i18n.__('Search results', 'surecart') : undefined,
        ]
            .filter(item => !!item)
            .join(' - ');
        this.scProductsViewed.emit({
            products: this.products,
            pageTitle: title,
            collectionId: this.collectionId,
        });
    }
    componentWillLoad() {
        var _a;
        if (!((_a = this === null || this === void 0 ? void 0 : this.products) === null || _a === void 0 ? void 0 : _a.length)) {
            this.getProducts();
        }
        else {
            this.handleProductsChanged(this.products);
        }
        if (this.collectionEnabled) {
            this.getCollections();
        }
    }
    // Append URL if no 'product-page' found
    doPagination(page) {
        // handle ajax pagination
        if (this.ajaxPagination) {
            this.page = page;
            this.updateProducts();
            this.paginationAutoScroll && this.el.scrollIntoView({ behavior: 'smooth' });
            return;
        }
        // handle server pagination.
        const newUrl = addQueryArgs(location.href, { 'product-page': page });
        window.location.replace(newUrl);
    }
    // Fetch all products
    async getProducts() {
        const { 'product-page': page } = getQueryArgs(window.location.href);
        this.page = this.paginationEnabled && page ? parseInt(page) : 1;
        try {
            this.loading = true;
            await this.fetchProducts();
        }
        catch (error) {
            console.error(error);
        }
        finally {
            this.loading = false;
        }
    }
    // Fetch all collections
    async getCollections() {
        try {
            this.collections = (await apiFetch({
                path: addQueryArgs('surecart/v1/product_collections/', {
                    per_page: 100,
                }),
            }));
        }
        catch (error) {
            console.error(error);
        }
    }
    async handleSortChange() {
        this.page = 1;
        this.updateProducts();
    }
    async updateProducts(emitSearchEvent = false) {
        var _a;
        try {
            this.busy = true;
            await this.fetchProducts();
            if (!!this.query && emitSearchEvent) {
                this.scSearched.emit({
                    searchString: this.query,
                    searchResultCount: (_a = this.products) === null || _a === void 0 ? void 0 : _a.length,
                    searchResultIds: this.products.map(product => product.id),
                });
            }
        }
        catch (error) {
            console.log('error');
            console.error(error);
            this.error = error.message || wp.i18n.__('An unknown error occurred.', 'surecart');
        }
        finally {
            this.busy = false;
        }
    }
    handleIdsChange() {
        if (this.debounce !== null) {
            clearTimeout(this.debounce);
            this.debounce = null;
        }
        this.debounce = window.setTimeout(() => {
            // your debounced traitment
            this.updateProducts();
            this.debounce = null;
        }, 200);
    }
    async fetchProducts() {
        var _a, _b;
        let collectionIds = ((_a = this.selectedCollections) === null || _a === void 0 ? void 0 : _a.map(collection => collection.id)) || [];
        // If we have a collectionId, we should only fetch products from that collection.
        if (this.collectionId) {
            collectionIds = [this.collectionId];
        }
        try {
            const response = (await apiFetch({
                path: addQueryArgs(`surecart/v1/products/`, {
                    expand: ['prices', 'featured_product_media', 'product_medias', 'product_media.media', 'variants'],
                    archived: false,
                    status: ['published'],
                    per_page: this.limit,
                    page: this.page,
                    sort: this.sort,
                    product_collection_ids: collectionIds,
                    ...(this.featured ? { featured: true } : {}),
                    ...(((_b = this.ids) === null || _b === void 0 ? void 0 : _b.length) ? { ids: this.ids } : {}),
                    ...(this.query ? { query: this.query } : {}),
                }),
                parse: false,
            }));
            this.currentQuery = this.query;
            this.pagination = {
                total: parseInt(response.headers.get('X-WP-Total')),
                total_pages: parseInt(response.headers.get('X-WP-TotalPages')),
            };
            this.products = (await response.json());
            if (!!collectionIds.length || !!this.query) {
                speak(wp.i18n.sprintf(wp.i18n.__('%s products found', 'surecart'), this.pagination.total));
            }
        }
        catch (response) {
            // we will want to handle nonce error if we are bypassing the apiFetch parser.
            await handleNonceError(response)
                .then(() => this.fetchProducts())
                .catch(error => {
                this.error = error.message || wp.i18n.__('An unknown error occurred.', 'surecart');
            });
        }
    }
    renderSortName() {
        switch (this.sort) {
            case 'cataloged_at:desc':
                return wp.i18n.__('Latest', 'surecart');
            case 'cataloged_at:asc':
                return wp.i18n.__('Oldest', 'surecart');
            case 'name:asc':
                return wp.i18n.__('Alphabetical, A-Z', 'surecart');
            case 'name:desc':
                return wp.i18n.__('Alphabetical, Z-A', 'surecart');
            default:
                return wp.i18n.__('Sort', 'surecart');
        }
    }
    toggleSelectCollection(collection) {
        // if collection not in selectedCollections, add it, otherwise remove it
        if (!this.selectedCollections.find(c => c.id === collection.id)) {
            this.selectedCollections = [...this.selectedCollections, collection];
        }
        else {
            this.selectedCollections = this.selectedCollections.filter(c => c.id !== collection.id);
        }
    }
    getCollectionsAfterFiltered() {
        var _a;
        return ((_a = this.collections) !== null && _a !== void 0 ? _a : []).filter(collection => {
            return !this.selectedCollections.some(selected => selected.id === collection.id);
        });
    }
    isPaginationAvailable() {
        var _a;
        return !!((_a = this.products) === null || _a === void 0 ? void 0 : _a.length) && this.pagination.total > this.products.length && this.paginationEnabled;
    }
    render() {
        var _a, _b, _c, _d, _e, _f;
        return (h("div", { key: '6408c64fbd0b59e9aa1b0359b0dfcc490f4a8f2e', class: {
                'product-item-list__wrapper': true,
                'product-item-list__has-search': !!this.query,
            } }, this.error && (h("sc-alert", { key: 'cb15953f986ef3f1d88f3f837f50d3ce47a3216c', type: "danger", open: true }, this.error)), (this.searchEnabled || this.sortEnabled || this.collectionEnabled) && (h("div", { key: 'a101ad04a589e86fa9f0c8d093d41c10a40866cd', class: "product-item-list__header" }, h("div", { key: 'e55564b57eaa31b336b9f70820e8394790529b22', class: "product-item-list__controls" }, h("div", { key: '23123b910e85dc008e9d7984ec18a6608c65598c', class: "product-item-list__sort" }, this.sortEnabled && (h("sc-dropdown", { key: '83eadbcb43854c20f7bab062471e60e8076cd275', style: { '--panel-width': '15em' } }, h("sc-button", { key: '79671e76fb3e790e7938bd48b12dffb8a491efe7', type: "text", caret: true, slot: "trigger" }, h("sc-visually-hidden", { key: 'b807aa612abcea288ff2ea851d6e94f6e8e09c22' }, wp.i18n.__('Dropdown to sort products.', 'surecart'), " "), this.renderSortName(), h("sc-visually-hidden", { key: 'd3f51057f0fb170e8465c5d938551989ef0e335e' }, " ", wp.i18n.__('selected.', 'surecart'))), h("sc-menu", { key: '1748bb7c348d2984a531f3eeaa5b3b17b3687c8c', "aria-label": wp.i18n.__('Sort Products', 'surecart') }, h("sc-menu-item", { key: '53f7e6fbfb1e390e19435a4a5ba7fd9c35f05fa9', "aria-label": wp.i18n.__('Sort by latest', 'surecart'), onClick: () => (this.sort = 'cataloged_at:desc') }, wp.i18n.__('Latest', 'surecart')), h("sc-menu-item", { key: 'f55715b201942ca079ac51d04887071833c3e9ba', "aria-label": wp.i18n.__('Sort by oldest', 'surecart'), onClick: () => (this.sort = 'cataloged_at:asc') }, wp.i18n.__('Oldest', 'surecart')), h("sc-menu-item", { key: '2ddd3d99ece189731314d33cfea794aa2cb9c80f', "aria-label": wp.i18n.__('Sort by name, A to Z', 'surecart'), onClick: () => (this.sort = 'name:asc') }, wp.i18n.__('Alphabetical, A-Z', 'surecart')), h("sc-menu-item", { key: '4003d5a412b3d0ed9a9607396632d0c37bc0acc4', "aria-label": wp.i18n.__('Sort by name, Z to A', 'surecart'), onClick: () => (this.sort = 'name:desc') }, wp.i18n.__('Alphabetical, Z-A', 'surecart'))))), this.collectionEnabled && ((_a = this.collections) !== null && _a !== void 0 ? _a : []).length > 0 && (h("sc-dropdown", { key: '5d802aad1f066a874d7712147ed19e1a7089c158', style: { '--panel-width': '15rem' } }, h("sc-button", { key: 'fcb4357e8da11867435a290fb7b1b177f8536b03', type: "text", caret: true, slot: "trigger" }, h("sc-visually-hidden", { key: '38c5edb5b1dd1424ac47ad7ec110e93e854c696b' }, wp.i18n.sprintf(wp.i18n.__('Dropdown to filter products by collection. %s selected.', 'surecart'), ((_b = this.selectedCollections) === null || _b === void 0 ? void 0 : _b.length) ? this.selectedCollections.map(collection => collection === null || collection === void 0 ? void 0 : collection.name).join(',') : wp.i18n.__('None', 'surecart'))), h("span", { key: '5b9bc299add9b062b54a9bc1e8fe706642b0948e', "aria-hidden": true }, " ", wp.i18n.__('Filter', 'surecart'))), h("sc-menu", { key: '1fc5548d30df5fc47ca85c340becbbca97fb9a28', "aria-label": wp.i18n.__('Filter products', 'surecart') }, ((_c = this.collections) !== null && _c !== void 0 ? _c : []).map(collection => {
            return (h("sc-menu-item", { checked: this.selectedCollections.some(selected => (selected === null || selected === void 0 ? void 0 : selected.id) === (collection === null || collection === void 0 ? void 0 : collection.id)), onClick: () => this.toggleSelectCollection(collection), key: collection === null || collection === void 0 ? void 0 : collection.id, "aria-label": wp.i18n.sprintf(wp.i18n.__('Filter by %s', 'surecart'), collection === null || collection === void 0 ? void 0 : collection.name) }, collection.name));
        }))))), h("div", { key: 'a1504c73a5d0c071ab9195b89db82904de4e1da5', class: "product-item-list__search" }, this.searchEnabled &&
            (((_d = this.query) === null || _d === void 0 ? void 0 : _d.length) && this.query === this.currentQuery ? (h("div", { class: "product-item-list__search-tag" }, h("div", { class: "product-item-list__search-label" }, wp.i18n.__('Search Results:', 'surecart')), h("sc-tag", { clearable: true, onScClear: () => {
                    this.query = '';
                    this.currentQuery = '';
                    this.updateProducts();
                }, "aria-label": wp.i18n.sprintf(wp.i18n.__('Searched for %s. Press space to clear search.', 'surecart'), this.query) }, this.query))) : (h("sc-input", { type: "text", placeholder: wp.i18n.__('Search', 'surecart'), size: "small", onKeyUp: e => {
                    if (e.key === 'Enter') {
                        this.query = e.target.value;
                        this.updateProducts(true);
                    }
                }, value: this.query, clearable: true }, this.query ? (h("sc-icon", { class: "clear-button", slot: "prefix", name: "x", onClick: () => {
                    this.query = '';
                } })) : (h("sc-icon", { slot: "prefix", name: "search" })), h("sc-button", { class: "search-button", type: "link", slot: "suffix", busy: this.busy, onClick: () => {
                    this.updateProducts(true);
                } }, wp.i18n.__('Search', 'surecart'))))))), this.collectionEnabled && this.selectedCollections.length > 0 && (h("div", { key: '03a75bc5384dab3ffad8711a452a6ac24d5ab50a', class: "product-item-list__search-tag" }, this.selectedCollections.map(collection => (h("sc-tag", { key: collection === null || collection === void 0 ? void 0 : collection.id, clearable: true, onScClear: () => {
                this.toggleSelectCollection(collection);
            } }, collection === null || collection === void 0 ? void 0 : collection.name))))))), !((_e = this.products) === null || _e === void 0 ? void 0 : _e.length) && !this.loading && (h("sc-empty", { key: '04bc5a3be8805ed387e9df841e4e34df3f951439', class: "product-item-list__empty", icon: "shopping-bag" }, wp.i18n.__('No products found.', 'surecart'))), h("section", { key: '1b11f9a08ae5f231c477799ebd6e3c12b6d2ee45', class: "product-item-list", "aria-label": wp.i18n.__('Product list', 'surecart') }, this.loading
            ? [...Array(((_f = this.products) === null || _f === void 0 ? void 0 : _f.length) || this.limit || 10)].map((_, index) => (h("div", { class: "product-item-list__loader", key: index }, (this.layoutConfig || []).map(layout => {
                var _a, _b;
                switch (layout.blockName) {
                    case 'surecart/product-item-title':
                        return (h("div", { style: {
                                textAlign: 'var(--sc-product-title-align)',
                            } }, h("sc-skeleton", { style: {
                                width: '80%',
                                display: 'inline-block',
                            } })));
                    case 'surecart/product-item-image':
                        return (h("sc-skeleton", { style: {
                                'width': '100%',
                                'minHeight': '90%',
                                'aspectRatio': (_b = (_a = layout.attributes) === null || _a === void 0 ? void 0 : _a.ratio) !== null && _b !== void 0 ? _b : '1/1.4',
                                '--sc-border-radius-pill': '12px',
                                'display': 'inline-block',
                            } }));
                    case 'surecart/product-item-price':
                        return (h("div", { style: {
                                textAlign: 'var(--sc-product-price-align)',
                            } }, h("sc-skeleton", { style: {
                                width: '40%',
                                display: 'inline-block',
                            } })));
                    default:
                        return null;
                }
            }))))
            : (this.products || []).map((product, index) => {
                return (h("sc-product-item", { key: product === null || product === void 0 ? void 0 : product.id, ...(this.products.length - 1 === index
                        ? {
                            'aria-label': wp.i18n.sprintf(wp.i18n.__('You have reached the end of product list. %s', 'surecart'), this.isPaginationAvailable() ? wp.i18n.__('Press tab to browse more products using pagination.', 'surecart') : wp.i18n.__('No more products to browse.', 'surecart')),
                        }
                        : {}), exportparts: "title, price, image", product: product, layoutConfig: this.layoutConfig }));
            })), this.isPaginationAvailable() && (h("div", { key: '293890b47fc0c00064c9e7c4b480b7e7ccf75b2c', class: {
                'product-item-list__pagination': true,
                '--is-aligned-left': this.paginationAlignment === 'left',
                '--is-aligned-center': this.paginationAlignment === 'center',
                '--is-aligned-right': this.paginationAlignment === 'right',
            } }, h("sc-pagination", { key: '4c80a73728002f933d48642395cc026d98d39198', page: this.page, perPage: this.limit, total: this.pagination.total, totalPages: this.pagination.total_pages, totalShowing: this.limit, onScNextPage: () => this.doPagination(this.page + 1), onScPrevPage: () => this.doPagination(this.page - 1) }))), (this.busy || this.loading) && h("sc-block-ui", { key: 'ba5a393b08ea081b7dfbcdc873ae42271c28da4b' })));
    }
    get el() { return getElement(this); }
    static get watchers() { return {
        "products": ["handleProductsChanged"],
        "sort": ["handleSortChange"],
        "selectedCollections": ["handleSortChange"],
        "query": ["handleSortChange"],
        "ids": ["handleIdsChange"],
        "limit": ["handleIdsChange"],
        "featured": ["handleIdsChange"]
    }; }
};
ScProductItemList.style = ScProductItemListStyle0;

export { ScProductItemList as sc_product_item_list };

//# sourceMappingURL=sc-product-item-list.entry.js.map