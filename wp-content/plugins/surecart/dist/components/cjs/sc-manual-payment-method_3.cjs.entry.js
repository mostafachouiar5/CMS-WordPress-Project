'use strict';

Object.defineProperty(exports, '__esModule', { value: true });

const index = require('./index-8acc3c89.js');

const scManualPaymentMethodCss = ":host {\n  display: block;\n}\n\n.manual-payment-method {\n  display: flex;\n  align-items: center;\n  justify-content: flex-start;\n  gap: var(--sc-spacing-x-small);\n  flex-wrap: wrap;\n\n  &__title {\n    font-weight: var(--sc-font-weight-bold);\n    color: var(--sc-primary-color-900);\n  }\n\n  &__description {\n    color: var(--sc-primary-color-600);\n  }\n}\n";
const ScManualPaymentMethodStyle0 = scManualPaymentMethodCss;

const ScManualPaymentMethod = class {
    constructor(hostRef) {
        index.registerInstance(this, hostRef);
        this.paymentMethod = undefined;
        this.showDescription = false;
    }
    render() {
        var _a, _b;
        return (index.h("div", { key: '47bed3b41ae0903839c7c4891098925221ee6824', class: "manual-payment-method", part: "card" }, index.h("div", { key: '888d64e79bf95c316383f18ea42d417823b991ab', class: "payment-method__title" }, (_a = this.paymentMethod) === null || _a === void 0 ? void 0 : _a.name), this.showDescription && index.h("sc-prose", { key: 'b720bff65e2818dfdd444b216b9b3792db9ee7f4', class: "payment-method__description", innerHTML: (_b = this.paymentMethod) === null || _b === void 0 ? void 0 : _b.description })));
    }
};
ScManualPaymentMethod.style = ScManualPaymentMethodStyle0;

const scPaymentMethodCss = ":host{display:block}.payment-method{display:flex;align-items:center;justify-content:flex-start;gap:var(--sc-spacing-x-small)}.payment-method-icon{border-radius:var(--sc-cc-border-radius, 4px);line-height:0;overflow:hidden}";
const ScPaymentMethodStyle0 = scPaymentMethodCss;

const ScPaymentMethod = class {
    constructor(hostRef) {
        index.registerInstance(this, hostRef);
        this.paymentMethod = undefined;
        this.full = undefined;
        this.externalLink = undefined;
        this.externalLinkTooltipText = undefined;
    }
    renderBankAccountType(type) {
        if (type === 'checking') {
            return wp.i18n.__('Checking', 'surecart');
        }
        if (type === 'savings') {
            return wp.i18n.__('Savings', 'surecart');
        }
    }
    renderExternalLink() {
        return (!!this.externalLink && (index.h("sc-tooltip", { text: this.externalLinkTooltipText, type: "text" }, index.h("sc-button", { style: { color: 'var(--sc-color-gray-500)' }, type: "text", size: "small", href: this.externalLink, target: "_blank" }, index.h("sc-icon", { name: "external-link", style: { fontSize: '16px' } })))));
    }
    render() {
        var _a, _b, _c, _d, _e, _f, _g, _h, _j, _k, _l, _m, _o, _p, _q, _r, _s, _t, _u, _v;
        if ((_b = (_a = this.paymentMethod) === null || _a === void 0 ? void 0 : _a.bank_account) === null || _b === void 0 ? void 0 : _b.id) {
            const account = (_c = this.paymentMethod) === null || _c === void 0 ? void 0 : _c.bank_account;
            return (index.h("div", { class: "payment-method", part: "bank" }, index.h("span", null, this.renderBankAccountType(account === null || account === void 0 ? void 0 : account.account_type)), "**** ", account === null || account === void 0 ? void 0 :
                account.last4, this.renderExternalLink()));
        }
        if ((_e = (_d = this === null || this === void 0 ? void 0 : this.paymentMethod) === null || _d === void 0 ? void 0 : _d.payment_instrument) === null || _e === void 0 ? void 0 : _e.instrument_type) {
            const type = (_g = (_f = this === null || this === void 0 ? void 0 : this.paymentMethod) === null || _f === void 0 ? void 0 : _f.payment_instrument) === null || _g === void 0 ? void 0 : _g.instrument_type;
            if (!!((_h = this === null || this === void 0 ? void 0 : this.paymentMethod) === null || _h === void 0 ? void 0 : _h.payment_method_name)) {
                return (index.h("div", { class: "payment-method", part: "instrument" }, index.h("div", { class: "payment-method-icon" }, index.h("sc-icon", { style: { fontSize: '36px', '--height': '0.63em' }, name: type })), index.h("span", null, (_j = this === null || this === void 0 ? void 0 : this.paymentMethod) === null || _j === void 0 ? void 0 : _j.payment_method_name), this.renderExternalLink()));
            }
            if (type === 'paypal') {
                return (index.h("div", { class: "payment-method", part: "instrument" }, index.h("sc-icon", { style: { fontSize: '56px', lineHeight: '1', height: '28px' }, name: "paypal" })));
            }
            return (index.h("div", { class: "payment-method", part: "instrument" }, index.h("sc-tag", { exportparts: "base:payment_instrument", type: "info", pill: true }, index.h("span", { style: { textTransform: 'capitalize' } }, type, " ")), this.renderExternalLink()));
        }
        if ((_l = (_k = this.paymentMethod) === null || _k === void 0 ? void 0 : _k.card) === null || _l === void 0 ? void 0 : _l.brand) {
            return (index.h("div", { class: "payment-method", part: "card" }, index.h("sc-cc-logo", { style: { fontSize: '36px' }, brand: (_o = (_m = this.paymentMethod) === null || _m === void 0 ? void 0 : _m.card) === null || _o === void 0 ? void 0 : _o.brand }), index.h("sc-text", { style: { whiteSpace: 'nowrap', paddingRight: '6px' } }, "**** ", (_q = (_p = this.paymentMethod) === null || _p === void 0 ? void 0 : _p.card) === null || _q === void 0 ? void 0 :
                _q.last4), this.renderExternalLink()));
        }
        if ((_s = (_r = this.paymentMethod) === null || _r === void 0 ? void 0 : _r.paypal_account) === null || _s === void 0 ? void 0 : _s.id) {
            return (index.h("div", { class: "payment-method", part: "base", style: { gap: 'var(--sc-spacing-small)' } }, index.h("sc-icon", { style: { fontSize: '56px', lineHeight: '1', height: '28px' }, name: "paypal" }), this.full && (index.h("sc-text", { style: { '--font-size': 'var(--sc-font-size-small)' }, truncate: true }, (_u = (_t = this.paymentMethod) === null || _t === void 0 ? void 0 : _t.paypal_account) === null || _u === void 0 ? void 0 : _u.email)), this.renderExternalLink()));
        }
        return (_v = this === null || this === void 0 ? void 0 : this.paymentMethod) === null || _v === void 0 ? void 0 : _v.processor_type;
    }
};
ScPaymentMethod.style = ScPaymentMethodStyle0;

const scProseCss = ":host{display:block}:host{display:block;position:relative;width:100%;font-family:var(--sc-input-font-family);font-weight:var(--sc-input-font-weight);line-height:var(--sc-line-height-normal);letter-spacing:var(--sc-input-letter-spacing)}::slotted(*){}::slotted([class~='lead']){color:var(--sc-input-color);font-size:var(--sc-input-spacing-small);line-height:1.6;margin-top:1.2em;margin-bottom:1.2em}::slotted(strong){font-weight:var(--sc-font-weight-bold)}::slotted(ol){padding:0;margin-top:var(--sc-input-spacing-small);margin-bottom:var(--sc-input-spacing-small)}::slotted(ol>li){position:relative}::slotted(ul>li){position:relative}::slotted(hr){border-color:var(--sc-color-gray-400);border-top-width:1px;margin-top:3em;margin-bottom:3em}::slotted(blockquote){font-weight:var(--sc-font-weight-medium);font-style:italic;color:var(--sc-color-gray-800);border-left-width:0.25rem;border-left-color:var(--sc-color-gray-400);quotes:'\\201C''\\201D''\\2018''\\2019';margin-top:1.6em;margin-bottom:1.6em;padding-left:1em}::slotted(blockquote p:first-of-type::before){content:open-quote}::slotted(blockquote p:last-of-type::after){content:close-quote}::slotted(h1){font-weight:800;font-size:2.25em;margin-top:0;margin-bottom:0.8888889em;line-height:1.1111111}::slotted(h2){font-weight:700;font-size:1.5em;margin-top:2em;margin-bottom:1em;line-height:1.3333333}::slotted(h3){font-weight:600;font-size:var(--sc-input-spacing-small);margin-top:1.6em;margin-bottom:0.6em;line-height:1.6}::slotted(h4){font-weight:600;margin-top:1.5em;margin-bottom:0.5em;line-height:1.5}::slotted(figure figcaption){color:var(--sc-color-gray-600);font-size:0.875em;line-height:1.4285714;margin-top:0.8571429em}::slotted(code){color:var(--sc-color-gray-900);font-weight:600;font-size:0.875em}::slotted(code::before){content:'`'}::slotted(code::after){content:'`'}::slotted(pre){color:var(--sc-color-gray-300);background-color:var(--sc-color-gray-800);overflow-x:auto;font-size:0.875em;line-height:1.7142857;margin-top:1.7142857em;margin-bottom:1.7142857em;border-radius:0.375rem;padding-top:0.8571429em;padding-right:1.1428571em;padding-bottom:0.8571429em;padding-left:1.1428571em}::slotted(pre code){background-color:transparent;border-width:0;border-radius:0;padding:0;font-weight:400;color:inherit;font-size:inherit;font-family:inherit;line-height:inherit}::slotted(pre code::before){content:''}::slotted(pre code::after){content:''}::slotted(table){width:100%;table-layout:auto;text-align:left;margin-top:2em;margin-bottom:2em;font-size:0.875em;line-height:1.7142857}::slotted(thead){color:#1a202c;font-weight:600;border-bottom-width:1px;border-bottom-color:var(--sc-color-gray-400)}::slotted(thead th){vertical-align:bottom;padding-right:0.5714286em;padding-bottom:0.5714286em;padding-left:0.5714286em}::slotted(tbody tr){border-bottom-width:1px;border-bottom-color:var(--sc-color-gray-400)}::slotted(tbody tr:last-child){border-bottom-width:0}::slotted(tbody td){vertical-align:top;padding-top:0.5714286em;padding-right:0.5714286em;padding-bottom:0.5714286em;padding-left:0.5714286em}::slotted(p),::slotted(img),::slotted(video),::slotted(figure){padding:0 !important;margin-top:var(--sc-input-spacing-small) !important;margin-bottom:var(--sc-input-spacing-small) !important}::slotted(figure>*){margin-top:0;margin-bottom:0}::slotted(h2 code){font-size:0.875em}::slotted(h3 code){font-size:0.9em}::slotted(ul){margin-top:var(--sc-input-spacing-small);margin-bottom:var(--sc-input-spacing-small)}::slotted(li){margin-top:0.5em;margin-bottom:0.5em}::slotted(ul>li p){margin-top:0.75em;margin-bottom:0.75em}::slotted(ul>li>*:first-child){margin-top:var(--sc-input-spacing-small)}::slotted(ul>li>*:last-child){margin-bottom:var(--sc-input-spacing-small)}::slotted(ol>li>*:first-child){margin-top:var(--sc-input-spacing-small)}::slotted(ol>li>*:last-child){margin-bottom:var(--sc-input-spacing-small)}::slotted(ul ul),::slotted(ul ol),::slotted(ol ul),::slotted(ol ol){margin-top:0.75em;margin-bottom:0.75em}::slotted(hr+*){margin-top:0}::slotted(h2+*){margin-top:0}::slotted(h3+*){margin-top:0}::slotted(h4+*){margin-top:0}::slotted(thead th:first-child){padding-left:0}::slotted(thead th:last-child){padding-right:0}::slotted(tbody td:first-child){padding-left:0}::slotted(tbody td:last-child){padding-right:0}::slotted(:first-child){margin-top:0 !important}::slotted(:last-child){margin-bottom:0 !important}";
const ScProseStyle0 = scProseCss;

const ScProse = class {
    constructor(hostRef) {
        index.registerInstance(this, hostRef);
    }
    render() {
        return (index.h(index.Host, { key: '554cd18c3d19b2f49b93ac7320c903599d23bc3b' }, index.h("slot", { key: 'aa997e837a56831283820723796b1795625e2f91' })));
    }
};
ScProse.style = ScProseStyle0;

exports.sc_manual_payment_method = ScManualPaymentMethod;
exports.sc_payment_method = ScPaymentMethod;
exports.sc_prose = ScProse;

//# sourceMappingURL=sc-manual-payment-method_3.cjs.entry.js.map