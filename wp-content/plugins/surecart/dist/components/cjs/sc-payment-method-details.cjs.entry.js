'use strict';

Object.defineProperty(exports, '__esModule', { value: true });

const index = require('./index-8acc3c89.js');

const ScPaymentMethodDetails = class {
    constructor(hostRef) {
        index.registerInstance(this, hostRef);
        this.paymentMethod = undefined;
        this.editHandler = undefined;
    }
    render() {
        var _a, _b, _c, _d, _e, _f, _g, _h, _j, _k;
        return (index.h("sc-card", { key: 'f3a564ca0054cc2b63c7118a7fd0fe9f7c7d5eef' }, index.h("sc-flex", { key: '9a94202a2bdfebb868cfceec761ffcbc9c0e860e', alignItems: "center", justifyContent: "flex-start", style: { gap: '0.5em' } }, index.h("sc-payment-method", { key: '3910c58eaba789eb67d9258746e917104dcb1bcd', paymentMethod: this.paymentMethod }), index.h("div", { key: '2865b838d4195d269cd4f57f5021e5a7ae1b242c' }, !!((_b = (_a = this.paymentMethod) === null || _a === void 0 ? void 0 : _a.card) === null || _b === void 0 ? void 0 : _b.exp_month) && (index.h("span", { key: '0157bf9151b997ae06022e761df5b2a30088475f' }, 
        // Translators: %d/%d is month and year of expiration.
        wp.i18n.sprintf(wp.i18n.__('Exp. %d/%d', 'surecart'), (_d = (_c = this.paymentMethod) === null || _c === void 0 ? void 0 : _c.card) === null || _d === void 0 ? void 0 : _d.exp_month, (_f = (_e = this.paymentMethod) === null || _e === void 0 ? void 0 : _e.card) === null || _f === void 0 ? void 0 : _f.exp_year))), !!((_h = (_g = this.paymentMethod) === null || _g === void 0 ? void 0 : _g.paypal_account) === null || _h === void 0 ? void 0 : _h.email) && ((_k = (_j = this.paymentMethod) === null || _j === void 0 ? void 0 : _j.paypal_account) === null || _k === void 0 ? void 0 : _k.email)), index.h("sc-button", { key: 'ac181d36c3fc7fd410ba1f81941e0bc08f7ad64f', type: "text", circle: true, onClick: this.editHandler }, index.h("sc-icon", { key: '43eef4134afe057362bb324ff67811b092ec52f9', name: "edit-2" })))));
    }
};

exports.sc_payment_method_details = ScPaymentMethodDetails;

//# sourceMappingURL=sc-payment-method-details.cjs.entry.js.map