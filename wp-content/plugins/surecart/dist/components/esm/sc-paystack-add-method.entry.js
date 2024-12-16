import { r as registerInstance, h, H as Host } from './index-745b6bec.js';
import { s as se } from './inline-c012a0f9.js';
import { a as apiFetch } from './fetch-2032d11d.js';
import './add-query-args-0e2a8393.js';
import './remove-query-args-938c53ea.js';

const scPaystackAddMethodCss = ":host{display:block}";
const ScPaystackAddMethodStyle0 = scPaystackAddMethodCss;

const ScPaystackAddMethod = class {
    constructor(hostRef) {
        registerInstance(this, hostRef);
        this.liveMode = true;
        this.customerId = undefined;
        this.successUrl = undefined;
        this.currency = undefined;
        this.loading = undefined;
        this.loaded = undefined;
        this.error = undefined;
        this.paymentIntent = undefined;
    }
    async handlePaymentIntentCreate() {
        var _a, _b;
        const { public_key, access_code } = ((_b = (_a = this.paymentIntent) === null || _a === void 0 ? void 0 : _a.processor_data) === null || _b === void 0 ? void 0 : _b.paystack) || {};
        // we need this data.
        if (!public_key || !access_code)
            return;
        const paystack = new se();
        await paystack.newTransaction({
            key: public_key,
            accessCode: access_code, // We'll use accessCode which will handle product, price on our server.
            onSuccess: async (transaction) => {
                if ((transaction === null || transaction === void 0 ? void 0 : transaction.status) !== 'success') {
                    throw { message: wp.i18n.sprintf(wp.i18n.__('Paystack transaction could not be finished. Status: %s', 'surecart'), transaction === null || transaction === void 0 ? void 0 : transaction.status) };
                }
                window.location.assign(this.successUrl);
            },
            onClose: err => {
                console.error(err);
                alert((err === null || err === void 0 ? void 0 : err.message) || wp.i18n.__('The payment did not process. Please try again.', 'surecart'));
            },
        });
    }
    async createPaymentIntent() {
        var _a, _b;
        try {
            this.loading = true;
            this.error = '';
            this.paymentIntent = await apiFetch({
                method: 'POST',
                path: 'surecart/v1/payment_intents',
                data: {
                    processor_type: 'paystack',
                    reusable: true,
                    live_mode: this.liveMode,
                    customer_id: this.customerId,
                    currency: this.currency,
                    refresh_status: true,
                },
            });
        }
        catch (e) {
            this.error = ((_b = (_a = e === null || e === void 0 ? void 0 : e.additional_errors) === null || _a === void 0 ? void 0 : _a[0]) === null || _b === void 0 ? void 0 : _b.message) || (e === null || e === void 0 ? void 0 : e.message) || wp.i18n.__('Something went wrong', 'surecart');
        }
        finally {
            this.loading = false;
        }
    }
    render() {
        return (h(Host, { key: '71b5eaa5a8711fd2b2324fe22ac80f17db19b4fe' }, this.error && (h("sc-alert", { key: '9f0a1bc2225a89dd292bdc9dbc4d65286c756d92', open: !!this.error, type: "danger" }, h("span", { key: '4461970f9e9c067d0411f84cb30b66eeb6ae014c', slot: "title" }, wp.i18n.__('Error', 'surecart')), this.error)), h("div", { key: '18e705e50952fbe805d5f5bd2e39d1c512eace48', class: "sc-paystack-button-container" }, h("sc-alert", { key: '70e3af27926b8c6e5d843761c0522d6fb29d64f5', open: true, type: "warning" }, wp.i18n.__('In order to add a new card, we will need to make a small transaction to authenticate it. This is for authentication purposes and will be immediately refunded.', 'surecart'), h("div", { key: 'e4f5dc73e58ef161f15c2557b2fd3b3ac3b48f8a' }, h("sc-button", { key: '3a4646bff957eecd8fadabd34d908d14f358a1cd', loading: this.loading, type: "primary", onClick: () => this.createPaymentIntent(), style: { marginTop: 'var(--sc-spacing-medium)' } }, wp.i18n.__('Add New Card', 'surecart')))))));
    }
    static get watchers() { return {
        "paymentIntent": ["handlePaymentIntentCreate"]
    }; }
};
ScPaystackAddMethod.style = ScPaystackAddMethodStyle0;

export { ScPaystackAddMethod as sc_paystack_add_method };

//# sourceMappingURL=sc-paystack-add-method.entry.js.map