'use strict';

Object.defineProperty(exports, '__esModule', { value: true });

const index = require('./index-8acc3c89.js');
const getters = require('./getters-c1b89891.js');
const getters$1 = require('./getters-690e042a.js');
require('./util-b877b2bd.js');
require('./index-bcdafe6e.js');
require('./utils-ee1bb9d3.js');
require('./mutations-19357660.js');
require('./remove-query-args-b57e8cd3.js');
require('./add-query-args-49dcb630.js');
require('./index-fb76df07.js');
require('./google-59d23803.js');
require('./currency-71fce0f0.js');
require('./store-1fb3d249.js');
require('./price-653ec1cb.js');

const scExpressPaymentCss = "sc-express-payment{display:block}";
const ScExpressPaymentStyle0 = scExpressPaymentCss;

const ScExpressPayment = class {
    constructor(hostRef) {
        index.registerInstance(this, hostRef);
        this.processor = undefined;
        this.dividerText = undefined;
        this.debug = undefined;
        this.hasPaymentOptions = undefined;
    }
    onPaymentRequestLoaded() {
        this.hasPaymentOptions = true;
    }
    renderStripePaymentRequest() {
        const { processor_data } = getters.getProcessorByType('stripe') || {};
        return index.h("sc-stripe-payment-request", { debug: this.debug, stripeAccountId: processor_data === null || processor_data === void 0 ? void 0 : processor_data.account_id, publishableKey: processor_data === null || processor_data === void 0 ? void 0 : processor_data.publishable_key });
    }
    render() {
        return (index.h(index.Host, { key: '03d79ade65f62e194567328e2110be7685c833ce', class: { 'is-empty': !this.hasPaymentOptions && !this.debug } }, this.renderStripePaymentRequest(), (this.hasPaymentOptions || this.debug) && index.h("sc-divider", { key: '57d20315a41736e2bb259182052a9217c8bd82c4', style: { '--spacing': 'calc(var(--sc-form-row-spacing)/2)' } }, this.dividerText), !!getters$1.formBusy() && index.h("sc-block-ui", { key: '1fca0a7a58721ae3ec8569744c609be941ef52e7' })));
    }
};
ScExpressPayment.style = ScExpressPaymentStyle0;

exports.sc_express_payment = ScExpressPayment;

//# sourceMappingURL=sc-express-payment.cjs.entry.js.map