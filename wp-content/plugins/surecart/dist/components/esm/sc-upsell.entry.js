import { r as registerInstance, h, H as Host } from './index-745b6bec.js';
import './watchers-46ca00a4.js';
import { s as state } from './store-dcefd119.js';
import { c as isBusy } from './getters-b1d93841.js';
import { t as trackOffer, p as preview } from './mutations-30225b1b.js';
import './watchers-67501779.js';
import './index-06061d4e.js';
import './google-dd89f242.js';
import './currency-a0c9bff4.js';
import './google-a86aa761.js';
import './utils-e9ee502a.js';
import './util-50af2a83.js';
import './index-c5a96d53.js';
import './add-query-args-0e2a8393.js';
import './fetch-2032d11d.js';
import './remove-query-args-938c53ea.js';
import './mutations-ed6d0770.js';

const scUpsellCss = ":host{display:block}.confirm__icon{margin-bottom:var(--sc-spacing-medium);display:flex;justify-content:center}.confirm__icon-container{background:var(--sc-color-primary-500);width:55px;height:55px;border-radius:999999px;display:flex;align-items:center;justify-content:center;font-size:26px;line-height:1;color:white}";
const ScUpsellStyle0 = scUpsellCss;

const ScUpsell = class {
    constructor(hostRef) {
        registerInstance(this, hostRef);
    }
    componentWillLoad() {
        trackOffer();
        preview();
    }
    render() {
        var _a, _b, _c, _d, _e, _f, _g, _h, _j;
        const manualPaymentMethod = (_a = state.checkout) === null || _a === void 0 ? void 0 : _a.manual_payment_method;
        return (h(Host, { key: 'e0bd7fae3712d03728032918e6181057d4d3d1b0' }, h("slot", { key: '5b2e3a3418ec43ee9d6eaaf81ed5e7769f1ab3ea' }), isBusy() && h("sc-block-ui", { key: '55eabf65db2d383f824e809c92eb510041b69ab9', style: { 'z-index': '30', '--sc-block-ui-position': 'fixed' } }), h("sc-dialog", { key: 'e67185f02d31cd37f8846b2f6ed2719b1f34ce4d', open: state.loading === 'complete', style: { '--body-spacing': 'var(--sc-spacing-xxx-large)' }, noHeader: true, onScRequestClose: e => e.preventDefault() }, h("div", { key: '923a7b386af088712fc46ae7edab8bc36d95214d', class: "confirm__icon" }, h("div", { key: '77e7db08c7ca8e9d014afa1e63faeaab3588c295', class: "confirm__icon-container" }, h("sc-icon", { key: 'cda8b7a13bae75bbbdd3d15d8d4cffbfc9ca1a42', name: "check" }))), h("sc-dashboard-module", { key: '84e9fc75822805427a0defb80b2cc21c9230591d', heading: ((_c = (_b = state === null || state === void 0 ? void 0 : state.text) === null || _b === void 0 ? void 0 : _b.success) === null || _c === void 0 ? void 0 : _c.title) || wp.i18n.__('Thank you!', 'surecart'), style: { '--sc-dashboard-module-spacing': 'var(--sc-spacing-x-large)', 'textAlign': 'center' } }, h("span", { key: '521bad972d87e95191a2b2ccf5d4fa87aadbf6a2', slot: "description" }, ((_e = (_d = state === null || state === void 0 ? void 0 : state.text) === null || _d === void 0 ? void 0 : _d.success) === null || _e === void 0 ? void 0 : _e.description) || wp.i18n.__('Your purchase was successful. A receipt is on its way to your inbox.', 'surecart')), !!(manualPaymentMethod === null || manualPaymentMethod === void 0 ? void 0 : manualPaymentMethod.name) && !!(manualPaymentMethod === null || manualPaymentMethod === void 0 ? void 0 : manualPaymentMethod.instructions) && (h("sc-alert", { key: 'ac3e953b0d02566e8ef99fe9eb223247e813f08f', type: "info", open: true, style: { 'text-align': 'left' } }, h("span", { key: '22f5bd4fe83fb3aa7fd5f1846cad7134f629793a', slot: "title" }, manualPaymentMethod === null || manualPaymentMethod === void 0 ? void 0 : manualPaymentMethod.name), h("div", { key: '4ac526b8a096d8634f4c132dd310dd94be38c2ba', innerHTML: manualPaymentMethod === null || manualPaymentMethod === void 0 ? void 0 : manualPaymentMethod.instructions }))), h("sc-button", { key: '285c4c49700ac269cccc3e025537219293d5ce61', href: (_g = (_f = window === null || window === void 0 ? void 0 : window.scData) === null || _f === void 0 ? void 0 : _f.pages) === null || _g === void 0 ? void 0 : _g.dashboard, size: "large", type: "primary", autofocus: true }, ((_j = (_h = state === null || state === void 0 ? void 0 : state.text) === null || _h === void 0 ? void 0 : _h.success) === null || _j === void 0 ? void 0 : _j.button) || wp.i18n.__('Continue', 'surecart'), h("sc-icon", { key: '79d3d417f5e1c3aeec68461e29a918b18907a988', name: "arrow-right", slot: "suffix" }))))));
    }
};
ScUpsell.style = ScUpsellStyle0;

export { ScUpsell as sc_upsell };

//# sourceMappingURL=sc-upsell.entry.js.map