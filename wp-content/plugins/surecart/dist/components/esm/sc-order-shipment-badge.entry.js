import { r as registerInstance, h, H as Host } from './index-745b6bec.js';

const scOrderShipmentBadgeCss = ":host{display:inline-block}";
const ScOrderShipmentBadgeStyle0 = scOrderShipmentBadgeCss;

const status = {
    unshipped: wp.i18n.__('Not Shipped', 'surecart'),
    shipped: wp.i18n.__('Shipped', 'surecart'),
    partially_shipped: wp.i18n.__('Partially Shipped', 'surecart'),
    delivered: wp.i18n.__('Delivered', 'surecart'),
};
const type = {
    unshipped: 'default',
    shipped: 'info',
    partially_shipped: 'warning',
    delivered: 'success',
};
const ScOrderShipmentBadge = class {
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
ScOrderShipmentBadge.style = ScOrderShipmentBadgeStyle0;

export { ScOrderShipmentBadge as sc_order_shipment_badge };

//# sourceMappingURL=sc-order-shipment-badge.entry.js.map