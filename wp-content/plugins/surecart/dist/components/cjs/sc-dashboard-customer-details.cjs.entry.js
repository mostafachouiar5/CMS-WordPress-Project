'use strict';

Object.defineProperty(exports, '__esModule', { value: true });

const index = require('./index-8acc3c89.js');
const fetch = require('./fetch-f25a0cb0.js');
const lazy = require('./lazy-2b509fa7.js');
const addQueryArgs = require('./add-query-args-49dcb630.js');
require('./remove-query-args-b57e8cd3.js');

const scDashboardCustomerDetailsCss = ":host{display:block;position:relative}.customer-details{display:grid;gap:0.75em}";
const ScDashboardCustomerDetailsStyle0 = scDashboardCustomerDetailsCss;

const ScDashboardCustomerDetails = class {
    constructor(hostRef) {
        index.registerInstance(this, hostRef);
        this.customerId = undefined;
        this.heading = undefined;
        this.customer = undefined;
        this.loading = undefined;
        this.error = undefined;
    }
    componentWillLoad() {
        lazy.onFirstVisible(this.el, () => {
            this.fetch();
        });
    }
    async fetch() {
        if ('' === this.customerId) {
            return;
        }
        try {
            this.loading = true;
            this.customer = (await await fetch.apiFetch({
                path: addQueryArgs.addQueryArgs(`surecart/v1/customers/${this.customerId}`, {
                    expand: ['shipping_address', 'billing_address', 'tax_identifier'],
                }),
            }));
        }
        catch (e) {
            if (e === null || e === void 0 ? void 0 : e.message) {
                this.error = e.message;
            }
            else {
                this.error = wp.i18n.__('Something went wrong', 'surecart');
            }
            console.error(this.error);
        }
        finally {
            this.loading = false;
        }
    }
    render() {
        return (index.h("sc-customer-details", { key: '1896331a0ec0570d43006588d70ed8bfa9d85b99', customer: this.customer, loading: this.loading, error: this.error, heading: this.heading, "edit-link": addQueryArgs.addQueryArgs(window.location.href, {
                action: 'edit',
                model: 'customer',
                id: this.customerId,
            }) }));
    }
    get el() { return index.getElement(this); }
};
ScDashboardCustomerDetails.style = ScDashboardCustomerDetailsStyle0;

exports.sc_dashboard_customer_details = ScDashboardCustomerDetails;

//# sourceMappingURL=sc-dashboard-customer-details.cjs.entry.js.map