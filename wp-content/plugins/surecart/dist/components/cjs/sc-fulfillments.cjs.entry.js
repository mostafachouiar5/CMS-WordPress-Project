'use strict';

Object.defineProperty(exports, '__esModule', { value: true });

const index = require('./index-8acc3c89.js');
const fetch = require('./fetch-f25a0cb0.js');
const addQueryArgs = require('./add-query-args-49dcb630.js');
require('./remove-query-args-b57e8cd3.js');

const scFulfillmentsCss = ".fulfillment{display:grid;gap:var(--sc-spacing-x-large)}.fulfillment__number{font-weight:bold}.fulfillment__header{display:flex;align-items:center;gap:var(--sc-spacing-medium)}sc-card{--sc-card-padding:var(--sc-spacing-x-large)}.trackings{display:flex;gap:0.75em;color:var(--sc-line-item-title-color, var(--sc-input-label-color))}.trackings__title{line-height:var(--sc-line-height-dense);font-weight:var(--sc-font-weight-bold)}.trackings sc-icon{opacity:0.5;font-size:22px}.line_items{display:grid;gap:var(--sc-spacing-large)}.line_item__info{display:flex;gap:var(--sc-spacing-medium);align-items:center}.line_item__image img{width:var(--sc-product-line-item-image-size, 4em);height:var(--sc-product-line-item-image-size, 4em);object-fit:cover;border-radius:4px;border:solid 1px var(--sc-input-border-color, var(--sc-input-border));display:block;box-shadow:var(--sc-input-box-shadow)}";
const ScFulfillmentsStyle0 = scFulfillmentsCss;

const ScFulfillments = class {
    constructor(hostRef) {
        index.registerInstance(this, hostRef);
        this.orderId = undefined;
        this.heading = undefined;
        this.fulfillments = undefined;
        this.loading = undefined;
        this.busy = undefined;
        this.error = undefined;
    }
    componentDidLoad() {
        this.fetch();
    }
    async fetch() {
        try {
            this.busy = true;
            this.fulfillments = (await fetch.apiFetch({
                path: addQueryArgs.addQueryArgs(`surecart/v1/fulfillments`, {
                    expand: ['trackings', 'fulfillment_items', 'fulfillment_item.line_item', 'line_item.price', 'price.product'],
                    order_ids: [this.orderId],
                    shipment_status: ['shipped', 'delivered'],
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
    renderLoading() {
        return (index.h("sc-flex", { flexDirection: "column", style: { gap: '1em' } }, index.h("sc-skeleton", { style: { width: '20%', display: 'inline-block' } }), index.h("sc-skeleton", { style: { width: '60%', display: 'inline-block' } }), index.h("sc-skeleton", { style: { width: '40%', display: 'inline-block' } })));
    }
    render() {
        var _a, _b;
        if (this.loading || !((_a = this.fulfillments) === null || _a === void 0 ? void 0 : _a.length))
            return index.h(index.Host, { style: { display: 'none' } });
        return (index.h("sc-spacing", { style: { '--spacing': 'var(--sc-spacing-large)' } }, index.h("sc-dashboard-module", { error: this.error }, index.h("span", { slot: "heading" }, this.heading || wp.i18n._n('Shipment', 'Shipments', (_b = this.fulfillments) === null || _b === void 0 ? void 0 : _b.length, 'surecart')), this.fulfillments.map(fulfillment => {
            var _a, _b, _c, _d, _e, _f;
            return (index.h("sc-card", { noPadding: true }, index.h("sc-stacked-list", null, index.h("sc-stacked-list-row", null, index.h("div", { class: "fulfillment__header" }, index.h("sc-fulfillment-shipping-status-badge", { status: fulfillment.shipment_status }), index.h("div", { class: "fulfillment__number" }, "#", fulfillment === null || fulfillment === void 0 ? void 0 :
                fulfillment.number))), !!((_b = (_a = fulfillment === null || fulfillment === void 0 ? void 0 : fulfillment.trackings) === null || _a === void 0 ? void 0 : _a.data) === null || _b === void 0 ? void 0 : _b.length) && (index.h("sc-stacked-list-row", null, index.h("div", { class: "trackings" }, index.h("sc-icon", { name: "truck" }), index.h("div", { class: "trackings__details" }, index.h("div", { class: "trackings__title" }, wp.i18n._n('Tracking number', 'Tracking numbers', (_d = (_c = fulfillment === null || fulfillment === void 0 ? void 0 : fulfillment.trackings) === null || _c === void 0 ? void 0 : _c.data) === null || _d === void 0 ? void 0 : _d.length, 'surecart')), index.h("div", { class: "trackings__list" }, (((_e = fulfillment === null || fulfillment === void 0 ? void 0 : fulfillment.trackings) === null || _e === void 0 ? void 0 : _e.data) || []).map(({ number, url }) => (index.h("a", { href: url, target: "_blank" }, number)))))))), (((_f = fulfillment === null || fulfillment === void 0 ? void 0 : fulfillment.fulfillment_items) === null || _f === void 0 ? void 0 : _f.data) || []).map(({ id, line_item, quantity }) => {
                var _a, _b, _c, _d, _e, _f, _g, _h, _j, _k, _l, _m;
                return (index.h("sc-stacked-list-row", { key: id, style: { '--columns': '2' } }, index.h("div", null, index.h("div", { class: "line_item__info" }, index.h("div", { class: "line_item__image" }, !!((_b = (_a = line_item === null || line_item === void 0 ? void 0 : line_item.price) === null || _a === void 0 ? void 0 : _a.product) === null || _b === void 0 ? void 0 : _b.line_item_image) && index.h("img", { ...(_d = (_c = line_item === null || line_item === void 0 ? void 0 : line_item.price) === null || _c === void 0 ? void 0 : _c.product) === null || _d === void 0 ? void 0 : _d.line_item_image })), index.h("div", { class: "line_item__text" }, index.h("div", null, (_f = (_e = line_item === null || line_item === void 0 ? void 0 : line_item.price) === null || _e === void 0 ? void 0 : _e.product) === null || _f === void 0 ? void 0 : _f.name), index.h("div", null, !!((_h = (_g = line_item === null || line_item === void 0 ? void 0 : line_item.price) === null || _g === void 0 ? void 0 : _g.product) === null || _h === void 0 ? void 0 : _h.weight) && (index.h("sc-format-number", { type: "unit", value: (_k = (_j = line_item === null || line_item === void 0 ? void 0 : line_item.price) === null || _j === void 0 ? void 0 : _j.product) === null || _k === void 0 ? void 0 : _k.weight, unit: (_m = (_l = line_item === null || line_item === void 0 ? void 0 : line_item.price) === null || _l === void 0 ? void 0 : _l.product) === null || _m === void 0 ? void 0 : _m.weight_unit })))))), index.h("span", null, wp.i18n.sprintf(wp.i18n.__('Qty: %d', 'surecart'), quantity || 0))));
            }))));
        }))));
    }
    get el() { return index.getElement(this); }
};
ScFulfillments.style = ScFulfillmentsStyle0;

exports.sc_fulfillments = ScFulfillments;

//# sourceMappingURL=sc-fulfillments.cjs.entry.js.map