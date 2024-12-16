import { r as registerInstance, h } from './index-745b6bec.js';
import './watchers-46ca00a4.js';
import { s as state } from './store-dcefd119.js';
import './watchers-67501779.js';
import './index-06061d4e.js';
import './google-dd89f242.js';
import './currency-a0c9bff4.js';
import './google-a86aa761.js';
import './utils-e9ee502a.js';
import './util-50af2a83.js';
import './index-c5a96d53.js';
import './getters-b1d93841.js';
import './mutations-30225b1b.js';
import './fetch-2032d11d.js';
import './add-query-args-0e2a8393.js';
import './remove-query-args-938c53ea.js';
import './mutations-ed6d0770.js';

const scUpsellTotalsCss = ":host{display:block}";
const ScUpsellTotalsStyle0 = scUpsellTotalsCss;

const ScUpsellTotals = class {
    constructor(hostRef) {
        registerInstance(this, hostRef);
    }
    renderAmountDue() {
        var _a, _b, _c;
        return state.amount_due > 0 ? (h("sc-format-number", { type: "currency", value: state.amount_due, currency: ((_b = (_a = state === null || state === void 0 ? void 0 : state.line_item) === null || _a === void 0 ? void 0 : _a.price) === null || _b === void 0 ? void 0 : _b.currency) || 'usd' })) : !!((_c = state === null || state === void 0 ? void 0 : state.line_item) === null || _c === void 0 ? void 0 : _c.trial_amount) ? (wp.i18n.__('Trial', 'surecart')) : (wp.i18n.__('Free', 'surecart'));
    }
    render() {
        var _a, _b, _c, _d, _e, _f, _g, _h, _j, _k, _l, _m, _o, _p, _q, _r;
        return (h("sc-summary", { key: '58bfcc83bef2fa0859b07ca1fd0764dfa7da86e0', "open-text": "Total", "closed-text": "Total", collapsible: true, collapsed: true }, !!((_a = state.line_item) === null || _a === void 0 ? void 0 : _a.id) && h("span", { key: 'c83179a08867ef76b2525424f0c6df5091d439ae', slot: "price" }, this.renderAmountDue()), h("sc-divider", { key: '0253e6ac48bbcc9361d5c56871328cd2e9ec7c11' }), h("sc-line-item", { key: 'c7576de55de8900ba557c4d69981724f4a6b563e' }, h("span", { key: '72c30a7126295c5dc080e3274fad548bd96050f2', slot: "description" }, wp.i18n.__('Subtotal', 'surecart')), h("sc-format-number", { key: '0571dc0478c465e92c02bf7125a8ec20216e6047', slot: "price", type: "currency", value: (_b = state.line_item) === null || _b === void 0 ? void 0 : _b.subtotal_amount, currency: ((_d = (_c = state === null || state === void 0 ? void 0 : state.line_item) === null || _c === void 0 ? void 0 : _c.price) === null || _d === void 0 ? void 0 : _d.currency) || 'usd' })), (((_f = (_e = state === null || state === void 0 ? void 0 : state.line_item) === null || _e === void 0 ? void 0 : _e.fees) === null || _f === void 0 ? void 0 : _f.data) || [])
            .filter(fee => fee.fee_type === 'upsell') // only upsell fees.
            .map(fee => {
            var _a, _b;
            return (h("sc-line-item", null, h("span", { slot: "description" }, fee.description, " ", `(${wp.i18n.__('one time', 'surecart')})`), h("sc-format-number", { slot: "price", type: "currency", value: fee.amount, currency: ((_b = (_a = state === null || state === void 0 ? void 0 : state.line_item) === null || _a === void 0 ? void 0 : _a.price) === null || _b === void 0 ? void 0 : _b.currency) || 'usd' })));
        }), !!((_g = state.line_item) === null || _g === void 0 ? void 0 : _g.tax_amount) && (h("sc-line-item", { key: '8646b4379ef71cbdb996db499142a5327bb0e70b' }, h("span", { key: '73cb232e41135abab6ae6fab02b0f259eadcd4dc', slot: "description" }, wp.i18n.__('Tax', 'surecart')), h("sc-format-number", { key: '82eb739fd7707241e18fbbba9423415b3b812b03', slot: "price", type: "currency", value: (_h = state.line_item) === null || _h === void 0 ? void 0 : _h.tax_amount, currency: ((_k = (_j = state === null || state === void 0 ? void 0 : state.line_item) === null || _j === void 0 ? void 0 : _j.price) === null || _k === void 0 ? void 0 : _k.currency) || 'usd' }))), h("sc-divider", { key: 'a3bfcde26e7c96e5d282afaf64c4cd9ca473e8f1' }), h("sc-line-item", { key: 'c7edd66ede456739b772b7b810390c7af4da0003', style: { '--price-size': 'var(--sc-font-size-x-large)' } }, h("span", { key: 'dc7bcdd6d12d60895e7e18eb76b1c021e7eb9013', slot: "title" }, wp.i18n.__('Total', 'surecart')), h("sc-format-number", { key: 'd647e69d7def1e36a5f440c688abdd4b4f115c5f', slot: "price", type: "currency", value: (_l = state.line_item) === null || _l === void 0 ? void 0 : _l.total_amount, currency: ((_o = (_m = state === null || state === void 0 ? void 0 : state.line_item) === null || _m === void 0 ? void 0 : _m.price) === null || _o === void 0 ? void 0 : _o.currency) || 'usd' })), state.amount_due !== ((_p = state.line_item) === null || _p === void 0 ? void 0 : _p.total_amount) && (h("sc-line-item", { key: '2723b501aac48b33ef2e06cfaf81c1c14165814b', style: { '--price-size': 'var(--sc-font-size-x-large)' } }, h("span", { key: '5014156e3114e8c75379f2d7902fa29fe89b564e', slot: "title" }, wp.i18n.__('Amount Due', 'surecart')), h("span", { key: 'e236f360567e07fc27203dac803b4fd0ba6ac40c', slot: "price" }, h("sc-format-number", { key: 'dc3e547771e76adfbb77063bb071fe68750e2e39', slot: "price", type: "currency", value: state.amount_due, currency: ((_r = (_q = state === null || state === void 0 ? void 0 : state.line_item) === null || _q === void 0 ? void 0 : _q.price) === null || _r === void 0 ? void 0 : _r.currency) || 'usd' }))))));
    }
};
ScUpsellTotals.style = ScUpsellTotalsStyle0;

export { ScUpsellTotals as sc_upsell_totals };

//# sourceMappingURL=sc-upsell-totals.entry.js.map