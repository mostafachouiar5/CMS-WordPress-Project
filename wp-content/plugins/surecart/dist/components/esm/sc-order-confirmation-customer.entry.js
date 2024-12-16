import { r as registerInstance, h } from './index-745b6bec.js';
import { o as openWormhole } from './consumer-e06b16d3.js';

const scOrderConfirmationCustomerCss = ":host{display:block}";
const ScOrderConfirmationCustomerStyle0 = scOrderConfirmationCustomerCss;

const ScOrderConfirmationCustomer = class {
    constructor(hostRef) {
        registerInstance(this, hostRef);
        this.order = undefined;
        this.heading = undefined;
        this.customer = undefined;
        this.error = undefined;
        this.loading = undefined;
    }
    render() {
        if (!this.customer) {
            return null;
        }
        return (h("sc-customer-details", { customer: this.customer, loading: this.loading, error: this.error }, h("span", { slot: "heading" }, h("slot", { name: "heading" }, this.heading || wp.i18n.__('Billing Details', 'surecart')))));
    }
};
openWormhole(ScOrderConfirmationCustomer, ['order', 'customer', 'loading'], false);
ScOrderConfirmationCustomer.style = ScOrderConfirmationCustomerStyle0;

export { ScOrderConfirmationCustomer as sc_order_confirmation_customer };

//# sourceMappingURL=sc-order-confirmation-customer.entry.js.map