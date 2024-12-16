import { r as registerInstance, h } from './index-745b6bec.js';
import { o as openWormhole } from './consumer-e06b16d3.js';

const scOrderConfirmationDetailsCss = ":host{display:block}";
const ScOrderConfirmationDetailsStyle0 = scOrderConfirmationDetailsCss;

const ScOrderConfirmationDetails = class {
    constructor(hostRef) {
        registerInstance(this, hostRef);
        this.order = undefined;
        this.loading = undefined;
    }
    renderOrderStatus() {
        var _a, _b;
        if (((_a = this === null || this === void 0 ? void 0 : this.order) === null || _a === void 0 ? void 0 : _a.status) === 'processing') {
            return h("sc-tag", { type: "warning" }, wp.i18n.__('On Hold', 'surecart'));
        }
        return h("sc-order-status-badge", { status: (_b = this.order) === null || _b === void 0 ? void 0 : _b.status });
    }
    render() {
        var _a, _b;
        if (!!this.loading) {
            return (h("sc-dashboard-module", null, h("sc-skeleton", { slot: "heading", style: { width: '120px', display: 'inline-block' } }), h("sc-skeleton", { slot: "end", style: { width: '60px', display: 'inline-block' } }), h("sc-card", null, h("sc-line-item", null, h("sc-skeleton", { style: { 'width': '50px', 'height': '50px', '--border-radius': '0' }, slot: "image" }), h("sc-skeleton", { slot: "title", style: { width: '120px', display: 'inline-block' } }), h("sc-skeleton", { slot: "description", style: { width: '60px', display: 'inline-block' } }), h("sc-skeleton", { style: { width: '120px', display: 'inline-block' }, slot: "price" }), h("sc-skeleton", { style: { width: '60px', display: 'inline-block' }, slot: "price-description" })), h("sc-divider", null), h("sc-line-item", null, h("sc-skeleton", { slot: "title", style: { width: '120px', display: 'inline-block' } }), h("sc-skeleton", { style: { width: '120px', display: 'inline-block' }, slot: "price" })), h("sc-divider", null), h("sc-line-item", null, h("sc-skeleton", { slot: "title", style: { width: '120px', display: 'inline-block' } }), h("sc-skeleton", { style: { width: '120px', display: 'inline-block' }, slot: "price" })))));
        }
        if (!((_a = this.order) === null || _a === void 0 ? void 0 : _a.number))
            return;
        return (h("sc-dashboard-module", { class: "order" }, h("span", { slot: "heading" }, wp.i18n.sprintf(wp.i18n.__('Order #%s', 'surecart'), (_b = this.order) === null || _b === void 0 ? void 0 : _b.number)), h("span", { slot: "end" }, this.renderOrderStatus()), h("sc-card", null, h("sc-order-confirmation-line-items", null), h("sc-divider", null), h("sc-order-confirmation-totals", null))));
    }
};
openWormhole(ScOrderConfirmationDetails, ['order', 'loading'], false);
ScOrderConfirmationDetails.style = ScOrderConfirmationDetailsStyle0;

export { ScOrderConfirmationDetails as sc_order_confirmation_details };

//# sourceMappingURL=sc-order-confirmation-details.entry.js.map