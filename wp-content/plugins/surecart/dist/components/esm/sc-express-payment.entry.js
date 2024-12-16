import { r as registerInstance, h, H as Host } from './index-745b6bec.js';
import { g as getProcessorByType } from './getters-ff7a502e.js';
import { f as formBusy } from './getters-929aa1df.js';
import './util-50af2a83.js';
import './index-06061d4e.js';
import './utils-e9ee502a.js';
import './mutations-d5e8faea.js';
import './remove-query-args-938c53ea.js';
import './add-query-args-0e2a8393.js';
import './index-c5a96d53.js';
import './google-a86aa761.js';
import './currency-a0c9bff4.js';
import './store-7020541e.js';
import './price-d5770168.js';

const scExpressPaymentCss = "sc-express-payment{display:block}";
const ScExpressPaymentStyle0 = scExpressPaymentCss;

const ScExpressPayment = class {
    constructor(hostRef) {
        registerInstance(this, hostRef);
        this.processor = undefined;
        this.dividerText = undefined;
        this.debug = undefined;
        this.hasPaymentOptions = undefined;
    }
    onPaymentRequestLoaded() {
        this.hasPaymentOptions = true;
    }
    renderStripePaymentRequest() {
        const { processor_data } = getProcessorByType('stripe') || {};
        return h("sc-stripe-payment-request", { debug: this.debug, stripeAccountId: processor_data === null || processor_data === void 0 ? void 0 : processor_data.account_id, publishableKey: processor_data === null || processor_data === void 0 ? void 0 : processor_data.publishable_key });
    }
    render() {
        return (h(Host, { key: '03d79ade65f62e194567328e2110be7685c833ce', class: { 'is-empty': !this.hasPaymentOptions && !this.debug } }, this.renderStripePaymentRequest(), (this.hasPaymentOptions || this.debug) && h("sc-divider", { key: '57d20315a41736e2bb259182052a9217c8bd82c4', style: { '--spacing': 'calc(var(--sc-form-row-spacing)/2)' } }, this.dividerText), !!formBusy() && h("sc-block-ui", { key: '1fca0a7a58721ae3ec8569744c609be941ef52e7' })));
    }
};
ScExpressPayment.style = ScExpressPaymentStyle0;

export { ScExpressPayment as sc_express_payment };

//# sourceMappingURL=sc-express-payment.entry.js.map