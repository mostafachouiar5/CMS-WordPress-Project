'use strict';

Object.defineProperty(exports, '__esModule', { value: true });

const index = require('./index-8acc3c89.js');

const scOrderStatusBadgeCss = ":host{display:inline-block}";
const ScOrderStatusBadgeStyle0 = scOrderStatusBadgeCss;

const ScOrderStatusBadge = class {
    constructor(hostRef) {
        index.registerInstance(this, hostRef);
        this.status = undefined;
        this.size = 'medium';
        this.pill = false;
        this.clearable = false;
    }
    getType() {
        switch (this.status) {
            case 'processing':
                return 'warning';
            case 'paid':
                return 'success';
            case 'payment_failed':
                return 'danger';
            case 'canceled':
                return 'danger';
            case 'void':
                return 'danger';
            case 'canceled':
                return 'danger';
        }
    }
    getText() {
        switch (this.status) {
            case 'processing':
                return wp.i18n.__('Processing', 'surecart');
            case 'payment_failed':
                return wp.i18n.__('Payment Failed', 'surecart');
            case 'paid':
                return wp.i18n.__('Paid', 'surecart');
            case 'canceled':
                return wp.i18n.__('Canceled', 'surecart');
            case 'void':
                return wp.i18n.__('Canceled', 'surecart');
            case 'draft':
                return wp.i18n.__('Draft', 'surecart');
            default:
                return this.status;
        }
    }
    render() {
        return (index.h("sc-tag", { key: '72599a56efcb25595c89a9d26486f35ce2034b35', type: this.getType(), pill: this.pill }, this.getText()));
    }
};
ScOrderStatusBadge.style = ScOrderStatusBadgeStyle0;

exports.sc_order_status_badge = ScOrderStatusBadge;

//# sourceMappingURL=sc-order-status-badge.cjs.entry.js.map