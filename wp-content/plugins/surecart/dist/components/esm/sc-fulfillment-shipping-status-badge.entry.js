import { r as registerInstance, h, H as Host } from './index-745b6bec.js';

const scFulfillmentShippingStatusBadgeCss = ":host{display:inline-block}";
const ScFulfillmentShippingStatusBadgeStyle0 = scFulfillmentShippingStatusBadgeCss;

const status = {
    unshipped: wp.i18n.__('Not Shipped', 'surecart'),
    shipped: wp.i18n.__('Shipped', 'surecart'),
    delivered: wp.i18n.__('Delivered', 'surecart'),
};
const type = {
    unshipped: 'default',
    shipped: 'info',
    delivered: 'success',
};
const ScOrderStatusBadge = class {
    constructor(hostRef) {
        registerInstance(this, hostRef);
        this.status = undefined;
        this.size = 'medium';
        this.pill = false;
        this.clearable = false;
    }
    render() {
        // don't render if not shippable.
        if (this.status === 'unshippable') {
            return h(Host, { style: { display: 'none' } });
        }
        return (h("sc-tag", { type: type === null || type === void 0 ? void 0 : type[this === null || this === void 0 ? void 0 : this.status], pill: this.pill }, (status === null || status === void 0 ? void 0 : status[this.status]) || this.status));
    }
};
ScOrderStatusBadge.style = ScFulfillmentShippingStatusBadgeStyle0;

export { ScOrderStatusBadge as sc_fulfillment_shipping_status_badge };

//# sourceMappingURL=sc-fulfillment-shipping-status-badge.entry.js.map