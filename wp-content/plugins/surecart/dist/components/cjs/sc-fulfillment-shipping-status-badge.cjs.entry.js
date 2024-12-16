'use strict';

Object.defineProperty(exports, '__esModule', { value: true });

const index = require('./index-8acc3c89.js');

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
ScOrderStatusBadge.style = ScFulfillmentShippingStatusBadgeStyle0;

exports.sc_fulfillment_shipping_status_badge = ScOrderStatusBadge;

//# sourceMappingURL=sc-fulfillment-shipping-status-badge.cjs.entry.js.map