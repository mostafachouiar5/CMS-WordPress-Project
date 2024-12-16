'use strict';

Object.defineProperty(exports, '__esModule', { value: true });

const index = require('./index-8acc3c89.js');
require('./watchers-0ab7d3b1.js');
const store = require('./store-d24717c6.js');
require('./watchers-cb566474.js');
require('./index-bcdafe6e.js');
require('./google-03835677.js');
require('./currency-71fce0f0.js');
require('./google-59d23803.js');
require('./utils-ee1bb9d3.js');
require('./util-b877b2bd.js');
require('./index-fb76df07.js');
require('./getters-f6bbfe30.js');
require('./mutations-ca288ff4.js');
require('./fetch-f25a0cb0.js');
require('./add-query-args-49dcb630.js');
require('./remove-query-args-b57e8cd3.js');
require('./mutations-11c8f9a8.js');

const scUpsellTotalsCss = ":host{display:block}";
const ScUpsellTotalsStyle0 = scUpsellTotalsCss;

const ScUpsellTotals = class {
    constructor(hostRef) {
        index.registerInstance(this, hostRef);
    }
    renderAmountDue() {
        var _a, _b, _c;
        return store.state.amount_due > 0 ? (index.h("sc-format-number", { type: "currency", value: store.state.amount_due, currency: ((_b = (_a = store.state === null || store.state === void 0 ? void 0 : store.state.line_item) === null || _a === void 0 ? void 0 : _a.price) === null || _b === void 0 ? void 0 : _b.currency) || 'usd' })) : !!((_c = store.state === null || store.state === void 0 ? void 0 : store.state.line_item) === null || _c === void 0 ? void 0 : _c.trial_amount) ? (wp.i18n.__('Trial', 'surecart')) : (wp.i18n.__('Free', 'surecart'));
    }
    render() {
        var _a, _b, _c, _d, _e, _f, _g, _h, _j, _k, _l, _m, _o, _p, _q, _r;
        return (index.h("sc-summary", { key: '58bfcc83bef2fa0859b07ca1fd0764dfa7da86e0', "open-text": "Total", "closed-text": "Total", collapsible: true, collapsed: true }, !!((_a = store.state.line_item) === null || _a === void 0 ? void 0 : _a.id) && index.h("span", { key: 'c83179a08867ef76b2525424f0c6df5091d439ae', slot: "price" }, this.renderAmountDue()), index.h("sc-divider", { key: '0253e6ac48bbcc9361d5c56871328cd2e9ec7c11' }), index.h("sc-line-item", { key: 'c7576de55de8900ba557c4d69981724f4a6b563e' }, index.h("span", { key: '72c30a7126295c5dc080e3274fad548bd96050f2', slot: "description" }, wp.i18n.__('Subtotal', 'surecart')), index.h("sc-format-number", { key: '0571dc0478c465e92c02bf7125a8ec20216e6047', slot: "price", type: "currency", value: (_b = store.state.line_item) === null || _b === void 0 ? void 0 : _b.subtotal_amount, currency: ((_d = (_c = store.state === null || store.state === void 0 ? void 0 : store.state.line_item) === null || _c === void 0 ? void 0 : _c.price) === null || _d === void 0 ? void 0 : _d.currency) || 'usd' })), (((_f = (_e = store.state === null || store.state === void 0 ? void 0 : store.state.line_item) === null || _e === void 0 ? void 0 : _e.fees) === null || _f === void 0 ? void 0 : _f.data) || [])
            .filter(fee => fee.fee_type === 'upsell') // only upsell fees.
            .map(fee => {
            var _a, _b;
            return (index.h("sc-line-item", null, index.h("span", { slot: "description" }, fee.description, " ", `(${wp.i18n.__('one time', 'surecart')})`), index.h("sc-format-number", { slot: "price", type: "currency", value: fee.amount, currency: ((_b = (_a = store.state === null || store.state === void 0 ? void 0 : store.state.line_item) === null || _a === void 0 ? void 0 : _a.price) === null || _b === void 0 ? void 0 : _b.currency) || 'usd' })));
        }), !!((_g = store.state.line_item) === null || _g === void 0 ? void 0 : _g.tax_amount) && (index.h("sc-line-item", { key: '8646b4379ef71cbdb996db499142a5327bb0e70b' }, index.h("span", { key: '73cb232e41135abab6ae6fab02b0f259eadcd4dc', slot: "description" }, wp.i18n.__('Tax', 'surecart')), index.h("sc-format-number", { key: '82eb739fd7707241e18fbbba9423415b3b812b03', slot: "price", type: "currency", value: (_h = store.state.line_item) === null || _h === void 0 ? void 0 : _h.tax_amount, currency: ((_k = (_j = store.state === null || store.state === void 0 ? void 0 : store.state.line_item) === null || _j === void 0 ? void 0 : _j.price) === null || _k === void 0 ? void 0 : _k.currency) || 'usd' }))), index.h("sc-divider", { key: 'a3bfcde26e7c96e5d282afaf64c4cd9ca473e8f1' }), index.h("sc-line-item", { key: 'c7edd66ede456739b772b7b810390c7af4da0003', style: { '--price-size': 'var(--sc-font-size-x-large)' } }, index.h("span", { key: 'dc7bcdd6d12d60895e7e18eb76b1c021e7eb9013', slot: "title" }, wp.i18n.__('Total', 'surecart')), index.h("sc-format-number", { key: 'd647e69d7def1e36a5f440c688abdd4b4f115c5f', slot: "price", type: "currency", value: (_l = store.state.line_item) === null || _l === void 0 ? void 0 : _l.total_amount, currency: ((_o = (_m = store.state === null || store.state === void 0 ? void 0 : store.state.line_item) === null || _m === void 0 ? void 0 : _m.price) === null || _o === void 0 ? void 0 : _o.currency) || 'usd' })), store.state.amount_due !== ((_p = store.state.line_item) === null || _p === void 0 ? void 0 : _p.total_amount) && (index.h("sc-line-item", { key: '2723b501aac48b33ef2e06cfaf81c1c14165814b', style: { '--price-size': 'var(--sc-font-size-x-large)' } }, index.h("span", { key: '5014156e3114e8c75379f2d7902fa29fe89b564e', slot: "title" }, wp.i18n.__('Amount Due', 'surecart')), index.h("span", { key: 'e236f360567e07fc27203dac803b4fd0ba6ac40c', slot: "price" }, index.h("sc-format-number", { key: 'dc3e547771e76adfbb77063bb071fe68750e2e39', slot: "price", type: "currency", value: store.state.amount_due, currency: ((_r = (_q = store.state === null || store.state === void 0 ? void 0 : store.state.line_item) === null || _q === void 0 ? void 0 : _q.price) === null || _r === void 0 ? void 0 : _r.currency) || 'usd' }))))));
    }
};
ScUpsellTotals.style = ScUpsellTotalsStyle0;

exports.sc_upsell_totals = ScUpsellTotals;

//# sourceMappingURL=sc-upsell-totals.cjs.entry.js.map