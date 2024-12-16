import { r as registerInstance, h } from './index-745b6bec.js';
import { u as updateFormState, s as state } from './mutations-d5e8faea.js';
import { i as isRtl } from './page-align-0cdacf32.js';
import { f as formBusy } from './getters-929aa1df.js';
import { c as createOrUpdateCheckout } from './index-96490395.js';
import './index-06061d4e.js';
import './utils-e9ee502a.js';
import './remove-query-args-938c53ea.js';
import './add-query-args-0e2a8393.js';
import './index-c5a96d53.js';
import './google-a86aa761.js';
import './currency-a0c9bff4.js';
import './store-7020541e.js';
import './price-d5770168.js';
import './fetch-2032d11d.js';

const scOrderCouponFormCss = ":host{display:block}.coupon-form{position:relative}.form{opacity:0;visibility:hidden;height:0;transition:opacity var(--sc-transition-fast) ease-in-out}.coupon-form--is-open .form{opacity:1;visibility:visible;height:auto;margin-top:var(--sc-spacing-small);display:grid;gap:var(--sc-spacing-small)}.coupon-form--is-open .trigger{color:var(--sc-input-label-color)}.coupon-form--is-open .trigger:hover{text-decoration:none}.trigger{cursor:pointer;font-size:var(--sc-font-size-small);color:var(--sc-color-gray-500);user-select:none}.trigger:hover{text-decoration:underline}.order-coupon-form--is-rtl .trigger,.order-coupon-form--is-rtl .trigger:hover{text-align:right}";
const ScOrderCouponFormStyle0 = scOrderCouponFormCss;

const ScOrderCouponForm = class {
    constructor(hostRef) {
        registerInstance(this, hostRef);
        this.label = undefined;
        this.loading = undefined;
        this.collapsed = undefined;
        this.placeholder = undefined;
        this.buttonText = undefined;
        this.open = undefined;
        this.value = undefined;
        this.error = undefined;
    }
    async handleCouponApply(e) {
        var _a, _b, _c;
        const promotion_code = (e === null || e === void 0 ? void 0 : e.detail) || null;
        try {
            this.error = null;
            updateFormState('FETCH');
            state.checkout = (await createOrUpdateCheckout({
                id: state.checkout.id,
                data: {
                    discount: {
                        ...(promotion_code ? { promotion_code } : {}),
                    },
                },
            }));
            updateFormState('RESOLVE');
            await ((_a = this.couponForm) === null || _a === void 0 ? void 0 : _a.triggerFocus());
        }
        catch (error) {
            console.error(error);
            this.error = ((_c = (_b = error === null || error === void 0 ? void 0 : error.additional_errors) === null || _b === void 0 ? void 0 : _b[0]) === null || _c === void 0 ? void 0 : _c.message) || (error === null || error === void 0 ? void 0 : error.message) || wp.i18n.__('Something went wrong', 'surecart');
            updateFormState('REJECT');
        }
    }
    render() {
        var _a, _b, _c, _d, _e, _f, _g, _h, _j;
        // Do any line items have a recurring price?
        const hasRecurring = (_c = (_b = (_a = state === null || state === void 0 ? void 0 : state.checkout) === null || _a === void 0 ? void 0 : _a.line_items) === null || _b === void 0 ? void 0 : _b.data) === null || _c === void 0 ? void 0 : _c.some(item => { var _a; return (_a = item === null || item === void 0 ? void 0 : item.price) === null || _a === void 0 ? void 0 : _a.recurring_interval; });
        return (h("sc-coupon-form", { key: '6ffd838f7c44ac67cbfd0a02bb5e3ab8fae2ca06', ref: el => (this.couponForm = el), label: this.label || wp.i18n.__('Add Coupon Code', 'surecart'), collapsed: this.collapsed, placeholder: this.placeholder, loading: formBusy() && !((_f = (_e = (_d = state.checkout) === null || _d === void 0 ? void 0 : _d.line_items) === null || _e === void 0 ? void 0 : _e.data) === null || _f === void 0 ? void 0 : _f.length), busy: formBusy(), discount: (_g = state.checkout) === null || _g === void 0 ? void 0 : _g.discount, currency: (_h = state.checkout) === null || _h === void 0 ? void 0 : _h.currency, "discount-amount": (_j = state.checkout) === null || _j === void 0 ? void 0 : _j.discount_amount, class: {
                'order-coupon-form--is-rtl': isRtl(),
            }, "button-text": this.buttonText || wp.i18n.__('Apply', 'surecart'), "show-interval": hasRecurring, onScApplyCoupon: e => this.handleCouponApply(e), error: this.error }));
    }
};
ScOrderCouponForm.style = ScOrderCouponFormStyle0;

export { ScOrderCouponForm as sc_order_coupon_form };

//# sourceMappingURL=sc-order-coupon-form.entry.js.map