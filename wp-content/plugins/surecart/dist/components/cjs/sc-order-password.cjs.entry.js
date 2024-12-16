'use strict';

Object.defineProperty(exports, '__esModule', { value: true });

const index = require('./index-8acc3c89.js');
const consumer = require('./consumer-9f4ee0e3.js');

const scOrderPasswordCss = ":host{display:block}.password{display:grid;gap:var(--sc-form-row-spacing, 0.75em)}.password__hint{padding-top:0.36rem;color:red}";
const ScOrderPasswordStyle0 = scOrderPasswordCss;

const ScOrderPassword = class {
    constructor(hostRef) {
        index.registerInstance(this, hostRef);
        this.loggedIn = undefined;
        this.size = 'medium';
        this.value = '';
        this.pill = false;
        this.label = undefined;
        this.showLabel = true;
        this.help = '';
        this.placeholder = undefined;
        this.disabled = false;
        this.readonly = false;
        this.required = false;
        this.autofocus = undefined;
        this.emailExists = undefined;
        this.confirmation = false;
        this.confirmationLabel = undefined;
        this.confirmationPlaceholder = undefined;
        this.confirmationHelp = undefined;
        this.enableValidation = true;
    }
    async reportValidity() {
        var _a, _b;
        return (_b = (_a = this.input) === null || _a === void 0 ? void 0 : _a.reportValidity) === null || _b === void 0 ? void 0 : _b.call(_a);
    }
    render() {
        if (this.loggedIn) {
            return index.h(index.Host, { style: { display: 'none' } });
        }
        return (index.h("sc-password", { label: this.label, "aria-label": this.label, help: this.help, autofocus: this.autofocus, placeholder: this.placeholder, showLabel: this.showLabel, size: this.size ? this.size : 'medium', name: "password", ref: el => (this.input = el), value: this.value, required: this.required, disabled: this.disabled, enableValidation: this.enableValidation, confirmationHelp: this.confirmationHelp, confirmationLabel: this.confirmationLabel, confirmationPlaceholder: this.confirmationPlaceholder, confirmation: this.confirmation }));
    }
};
consumer.openWormhole(ScOrderPassword, ['loggedIn', 'emailExists'], false);
ScOrderPassword.style = ScOrderPasswordStyle0;

exports.sc_order_password = ScOrderPassword;

//# sourceMappingURL=sc-order-password.cjs.entry.js.map