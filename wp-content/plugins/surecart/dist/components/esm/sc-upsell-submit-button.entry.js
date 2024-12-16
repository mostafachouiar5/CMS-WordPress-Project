import { r as registerInstance, h, H as Host, a as getElement } from './index-745b6bec.js';
import './watchers-46ca00a4.js';
import { s as state } from './store-dcefd119.js';
import { s as state$1 } from './mutations-ed6d0770.js';
import { i as isProductOutOfStock, c as isSelectedVariantMissing } from './watchers-67501779.js';
import { a as accept } from './mutations-30225b1b.js';
import { c as isBusy } from './getters-b1d93841.js';
import './add-query-args-0e2a8393.js';
import './utils-e9ee502a.js';
import './index-06061d4e.js';
import './index-c5a96d53.js';
import './google-dd89f242.js';
import './currency-a0c9bff4.js';
import './google-a86aa761.js';
import './util-50af2a83.js';
import './fetch-2032d11d.js';
import './remove-query-args-938c53ea.js';

const scUpsellSubmitButtonCss = "sc-upsell-submit-button{position:relative;display:block}sc-upsell-submit-button .wp-block-button__link{position:relative;text-decoration:none}sc-upsell-submit-button .wp-block-button__link span sc-icon{padding-right:var(--sc-spacing-small)}sc-upsell-submit-button .wp-block-button__link [data-text],sc-upsell-submit-button .wp-block-button__link sc-spinner{display:flex;align-items:center;justify-content:center}sc-upsell-submit-button .sc-block-button--sold-out,sc-upsell-submit-button .sc-block-button--unavailable{display:none !important}sc-upsell-submit-button.is-unavailable .sc-block-button__link{display:none !important}sc-upsell-submit-button.is-unavailable .sc-block-button--unavailable{display:initial !important}sc-upsell-submit-button.is-sold-out .sc-block-button__link{display:none !important}sc-upsell-submit-button.is-sold-out .sc-block-button--sold-out{display:initial !important}sc-upsell-submit-button sc-spinner::part(base){--indicator-color:currentColor;--spinner-size:12px;position:absolute;top:calc(50% - var(--spinner-size) + var(--spinner-size) / 4);left:calc(50% - var(--spinner-size) + var(--spinner-size) / 4)}sc-upsell-submit-button [data-text],sc-upsell-submit-button [data-loader]{transition:opacity var(--sc-transition-fast) ease-in-out, visibility var(--sc-transition-fast) ease-in-out}sc-upsell-submit-button [data-loader]{opacity:0;visibility:hidden}sc-upsell-submit-button.is-disabled{pointer-events:none}sc-upsell-submit-button.is-busy [data-text]{opacity:0;visibility:hidden}sc-upsell-submit-button.is-busy [data-loader]{opacity:1;visibility:visible}sc-upsell-submit-button.is-out-of-stock [data-text]{opacity:0.6}";
const ScUpsellSubmitButtonStyle0 = scUpsellSubmitButtonCss;

const ScUpsellSubmitButton = class {
    constructor(hostRef) {
        registerInstance(this, hostRef);
    }
    getUpsellProductId() {
        var _a;
        return ((_a = state.product) === null || _a === void 0 ? void 0 : _a.id) || '';
    }
    async handleAddToOrderClick(e) {
        e.preventDefault();
        accept();
    }
    render() {
        return (h(Host, { key: '0cf139dcf3983df26a9147496b8900669e213a3f', class: {
                'is-busy': isBusy(),
                'is-disabled': state.disabled,
                // TODO: change this to out of stock error message.
                'is-sold-out': (isProductOutOfStock(this.getUpsellProductId()) && !isSelectedVariantMissing(this.getUpsellProductId())) || (state$1 === null || state$1 === void 0 ? void 0 : state$1.code) === 'out_of_stock',
                'is-unavailable': isSelectedVariantMissing(this.getUpsellProductId()) || (state$1 === null || state$1 === void 0 ? void 0 : state$1.code) === 'expired',
            }, onClick: e => this.handleAddToOrderClick(e) }, h("slot", { key: '430d13b9b60794b31a85ce7bce63426c33496d28' })));
    }
    get el() { return getElement(this); }
};
ScUpsellSubmitButton.style = ScUpsellSubmitButtonStyle0;

export { ScUpsellSubmitButton as sc_upsell_submit_button };

//# sourceMappingURL=sc-upsell-submit-button.entry.js.map