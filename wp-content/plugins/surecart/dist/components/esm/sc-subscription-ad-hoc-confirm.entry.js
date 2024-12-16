import { r as registerInstance, h } from './index-745b6bec.js';
import { i as intervalString } from './price-d5770168.js';
import { a as addQueryArgs } from './add-query-args-0e2a8393.js';
import './currency-a0c9bff4.js';

const scSubscriptionAdHocConfirmCss = ":host{display:block}";
const ScSubscriptionAdHocConfirmStyle0 = scSubscriptionAdHocConfirmCss;

const ScSubscriptionAdHocConfirm = class {
    constructor(hostRef) {
        registerInstance(this, hostRef);
        this.heading = undefined;
        this.price = undefined;
        this.busy = false;
    }
    async handleSubmit(e) {
        const { ad_hoc_amount } = await e.target.getFormJson();
        this.busy = true;
        return window.location.assign(addQueryArgs(window.location.href, {
            action: 'confirm',
            ad_hoc_amount,
        }));
    }
    render() {
        return (h("sc-dashboard-module", { key: '3ade2f39d61b46b9336298aef49749a5c439b17c', heading: this.heading || wp.i18n.__('Enter An Amount', 'surecart'), class: "subscription-switch" }, h("sc-card", { key: 'b946e77f2709a72da2e9637d94a908213c41206d' }, h("sc-form", { key: '1cc306fc2fe563831cd82d3bb8e364816081281d', onScSubmit: e => this.handleSubmit(e) }, h("sc-price-input", { key: '841df4948826d276c6b9f11826731a36252959a1', label: "Amount", name: "ad_hoc_amount", autofocus: true, required: true }, h("span", { key: 'a4bc62244096e571999c3fd82986ee5387a61d8b', slot: "suffix", style: { opacity: '0.75' } }, intervalString(this.price))), h("sc-button", { key: 'd7bd28e7cb83bd25e36f2ab7c2ca9c8eaaf6f6db', type: "primary", full: true, submit: true, loading: this.busy }, wp.i18n.__('Next', 'surecart'), " ", h("sc-icon", { key: '15fbca3071a34cc6ed315152b38ca99995945c46', name: "arrow-right", slot: "suffix" })))), this.busy && h("sc-block-ui", { key: '4a48f772cf6904d832d935cd53b652e47cbf445d', style: { zIndex: '9' } })));
    }
};
ScSubscriptionAdHocConfirm.style = ScSubscriptionAdHocConfirmStyle0;

export { ScSubscriptionAdHocConfirm as sc_subscription_ad_hoc_confirm };

//# sourceMappingURL=sc-subscription-ad-hoc-confirm.entry.js.map