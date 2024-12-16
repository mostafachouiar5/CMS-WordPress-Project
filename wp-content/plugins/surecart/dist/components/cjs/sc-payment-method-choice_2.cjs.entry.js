'use strict';

Object.defineProperty(exports, '__esModule', { value: true });

const index = require('./index-8acc3c89.js');
const watchers = require('./watchers-2ad3abd1.js');
require('./index-bcdafe6e.js');

const scPaymentMethodChoiceCss = ":host{display:block}:slotted([slot=\"summary\"]){line-height:1;display:flex;align-items:center;gap:0.5em}";
const ScPaymentMethodChoiceStyle0 = scPaymentMethodChoiceCss;

const ScPaymentMethodChoice = class {
    constructor(hostRef) {
        index.registerInstance(this, hostRef);
        this.methodId = undefined;
        this.processorId = undefined;
        this.isManual = undefined;
        this.card = undefined;
    }
    isSelected() {
        if (this.methodId) {
            return (watchers.state === null || watchers.state === void 0 ? void 0 : watchers.state.id) === this.processorId && (watchers.state === null || watchers.state === void 0 ? void 0 : watchers.state.method) == this.methodId;
        }
        return !(watchers.state === null || watchers.state === void 0 ? void 0 : watchers.state.method) && (watchers.state === null || watchers.state === void 0 ? void 0 : watchers.state.id) === this.processorId;
    }
    getAllOptions() {
        const parentGroup = this.el.closest('sc-payment') || this.el.parentElement;
        if (!parentGroup) {
            return [];
        }
        return [...parentGroup.querySelectorAll(this.el.tagName)];
    }
    getSiblingItems() {
        return this.getAllOptions().filter(choice => choice !== this.el);
    }
    hasOthers() {
        var _a;
        return !!((_a = this.getSiblingItems()) === null || _a === void 0 ? void 0 : _a.length);
    }
    render() {
        const Tag = this.hasOthers() ? 'sc-toggle' : 'div';
        return (index.h(Tag, { key: '15615764bcbc44710b31430388c108522e394d6e', "show-control": true, borderless: true, open: this.isSelected(), onScShow: () => {
                watchers.state.id = this.processorId;
                watchers.state.manual = !!this.isManual;
                watchers.state.method = this.methodId;
            } }, this.hasOthers() && index.h("slot", { key: '3f4eede11f01abd2697fa0004f436c2356d72176', name: "summary", slot: "summary" }), this.card && !this.hasOthers() ? (index.h("sc-card", null, index.h("slot", null))) : (index.h("slot", null))));
    }
    get el() { return index.getElement(this); }
};
ScPaymentMethodChoice.style = ScPaymentMethodChoiceStyle0;

const scPaymentSelectedCss = ":host{display:block}::slotted([slot=icon]){display:block;font-size:24px}.payment-selected{display:flex;flex-direction:column;gap:var(--sc-spacing-x-small)}.payment-selected__label{color:var(--sc-input-label-color);line-height:var(--sc-line-height-dense);font-size:var(--sc-font-size-medium)}.payment-selected__instructions{display:flex;justify-content:flex-start;align-items:center;gap:1em}.payment-selected__instructions svg{width:42px;height:42px;flex-shrink:0}.payment-selected__instructions-text{color:var(--sc-input-label-color);font-size:var(--sc-font-size-small);line-height:var(--sc-line-height-dense)}";
const ScPaymentSelectedStyle0 = scPaymentSelectedCss;

const ScPaymentSelected = class {
    constructor(hostRef) {
        index.registerInstance(this, hostRef);
        this.iconName = undefined;
        this.label = undefined;
    }
    render() {
        return (index.h("div", { key: '4aa3a78fc38c5d59506b00ee504c3ed21565bcce', class: "payment-selected", part: "base" }, index.h("slot", { key: 'cfdc7721bb017b74c95a5d745bfce99fdff58b8a', name: "icon" }), index.h("div", { key: '2d28f760921e6daed13840eb7188ea91c67a7eaf', class: "payment-selected__label" }, this.label), index.h("sc-divider", { key: '1f561482f530e031b333ef34659cb32f4b5c7f87', style: { '--spacing': 'var(--sc-spacing-xx-small)' }, exportparts: "base:divider, line:divider__line" }), index.h("div", { key: '6716989f2e67f04b868d68c9cc4356c1af2f9bd3', part: "instructions", class: "payment-selected__instructions" }, index.h("svg", { key: '7a1ba67f635a03bf7f1fd9d1a61ce69ecadb1b59', part: "icon", viewBox: "0 0 48 40", fill: "var(--sc-color-gray-500)", xmlns: "http://www.w3.org/2000/svg", role: "presentation" }, index.h("path", { key: '3976b62e7276812980fcbabedb1b8cc03284ccc2', opacity: ".6", "fill-rule": "evenodd", "clip-rule": "evenodd", d: "M43 5a4 4 0 00-4-4H17a4 4 0 00-4 4v11a1 1 0 102 0V5a2 2 0 012-2h22a2 2 0 012 2v30a2 2 0 01-2 2H17a2 2 0 01-2-2v-9a1 1 0 10-2 0v9a4 4 0 004 4h22a4 4 0 004-4V5zM17.992 16.409L21.583 20H6a1 1 0 100 2h15.583l-3.591 3.591a1 1 0 101.415 1.416l5.3-5.3a1 1 0 000-1.414l-5.3-5.3a1 1 0 10-1.415 1.416zM17 6a1 1 0 011-1h15a1 1 0 011 1v2a1 1 0 01-1 1H18a1 1 0 01-1-1V6zm21-1a1 1 0 100 2 1 1 0 000-2z" })), index.h("div", { key: 'ccf0b7600630c292173f7df49bab2f1bd8747fad', part: "text", class: "payment-selected__instructions-text" }, index.h("slot", { key: '408db7f701bf237a74b7210fe44872017dba9234' })))));
    }
};
ScPaymentSelected.style = ScPaymentSelectedStyle0;

exports.sc_payment_method_choice = ScPaymentMethodChoice;
exports.sc_payment_selected = ScPaymentSelected;

//# sourceMappingURL=sc-payment-method-choice_2.cjs.entry.js.map