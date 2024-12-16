'use strict';

Object.defineProperty(exports, '__esModule', { value: true });

const index = require('./index-8acc3c89.js');
const consumer = require('./consumer-9f4ee0e3.js');

const scOrderConfirmationDetailsCss = ":host{display:block}";
const ScOrderConfirmationDetailsStyle0 = scOrderConfirmationDetailsCss;

const ScOrderConfirmationDetails = class {
    constructor(hostRef) {
        index.registerInstance(this, hostRef);
        this.order = undefined;
        this.loading = undefined;
    }
    renderOrderStatus() {
        var _a, _b;
        if (((_a = this === null || this === void 0 ? void 0 : this.order) === null || _a === void 0 ? void 0 : _a.status) === 'processing') {
            return index.h("sc-tag", { type: "warning" }, wp.i18n.__('On Hold', 'surecart'));
        }
        return index.h("sc-order-status-badge", { status: (_b = this.order) === null || _b === void 0 ? void 0 : _b.status });
    }
    render() {
        var _a, _b;
        if (!!this.loading) {
            return (index.h("sc-dashboard-module", null, index.h("sc-skeleton", { slot: "heading", style: { width: '120px', display: 'inline-block' } }), index.h("sc-skeleton", { slot: "end", style: { width: '60px', display: 'inline-block' } }), index.h("sc-card", null, index.h("sc-line-item", null, index.h("sc-skeleton", { style: { 'width': '50px', 'height': '50px', '--border-radius': '0' }, slot: "image" }), index.h("sc-skeleton", { slot: "title", style: { width: '120px', display: 'inline-block' } }), index.h("sc-skeleton", { slot: "description", style: { width: '60px', display: 'inline-block' } }), index.h("sc-skeleton", { style: { width: '120px', display: 'inline-block' }, slot: "price" }), index.h("sc-skeleton", { style: { width: '60px', display: 'inline-block' }, slot: "price-description" })), index.h("sc-divider", null), index.h("sc-line-item", null, index.h("sc-skeleton", { slot: "title", style: { width: '120px', display: 'inline-block' } }), index.h("sc-skeleton", { style: { width: '120px', display: 'inline-block' }, slot: "price" })), index.h("sc-divider", null), index.h("sc-line-item", null, index.h("sc-skeleton", { slot: "title", style: { width: '120px', display: 'inline-block' } }), index.h("sc-skeleton", { style: { width: '120px', display: 'inline-block' }, slot: "price" })))));
        }
        if (!((_a = this.order) === null || _a === void 0 ? void 0 : _a.number))
            return;
        return (index.h("sc-dashboard-module", { class: "order" }, index.h("span", { slot: "heading" }, wp.i18n.sprintf(wp.i18n.__('Order #%s', 'surecart'), (_b = this.order) === null || _b === void 0 ? void 0 : _b.number)), index.h("span", { slot: "end" }, this.renderOrderStatus()), index.h("sc-card", null, index.h("sc-order-confirmation-line-items", null), index.h("sc-divider", null), index.h("sc-order-confirmation-totals", null))));
    }
};
consumer.openWormhole(ScOrderConfirmationDetails, ['order', 'loading'], false);
ScOrderConfirmationDetails.style = ScOrderConfirmationDetailsStyle0;

exports.sc_order_confirmation_details = ScOrderConfirmationDetails;

//# sourceMappingURL=sc-order-confirmation-details.cjs.entry.js.map