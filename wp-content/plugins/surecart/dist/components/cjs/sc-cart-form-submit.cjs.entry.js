'use strict';

Object.defineProperty(exports, '__esModule', { value: true });

const index = require('./index-8acc3c89.js');
const getters = require('./getters-690e042a.js');
require('./store-1fb3d249.js');
require('./index-bcdafe6e.js');
require('./utils-ee1bb9d3.js');

const scCartFormSubmitCss = "sc-order-submit{display:block;width:auto}";
const ScCartFormSubmitStyle0 = scCartFormSubmitCss;

const ScCartFormSubmit = class {
    constructor(hostRef) {
        index.registerInstance(this, hostRef);
        this.type = 'primary';
        this.size = 'medium';
        this.full = true;
        this.icon = undefined;
    }
    render() {
        return (index.h("sc-button", { key: '0271855c9ef605213b047fa5efd8ba751c680004', submit: true, type: this.type, size: this.size, full: this.full, loading: getters.formBusy(), disabled: getters.formBusy() }, !!this.icon && index.h("sc-icon", { key: 'e59ce21998399b6a77636b0a32e53f92f67eaf0f', name: this.icon, slot: "prefix" }), index.h("slot", { key: '1575bba984f73e6e4ab160599871b073caf4d0e6' })));
    }
};
ScCartFormSubmit.style = ScCartFormSubmitStyle0;

exports.sc_cart_form_submit = ScCartFormSubmit;

//# sourceMappingURL=sc-cart-form-submit.cjs.entry.js.map