'use strict';

Object.defineProperty(exports, '__esModule', { value: true });

const index = require('./index-8acc3c89.js');

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
        index.registerInstance(this, hostRef);
        this.status = undefined;
        this.size = 'medium';
        this.pill = false;
        this.clearable = false;
    }
    render() {
        // don't render if not shippable.
        if (this.status === 'unshippable') {
            return index.h(index.Host, { style: { display: 'none' } });
        }
        return (index.h("sc-tag", { type: type === null || type === void 0 ? void 0 : type[this === null || this === void 0 ? void 0 : this.status], pill: this.pill }, (status === null || status === void 0 ? void 0 : status[this.status]) || this.status));
    }
};
ScOrderShipmentBadge.style = ScOrderShipmentBadgeStyle0;

exports.sc_order_shipment_badge = ScOrderShipmentBadge;

//# sourceMappingURL=sc-order-shipment-badge.cjs.entry.js.map